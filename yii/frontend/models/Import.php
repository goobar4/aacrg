<?php

namespace frontend\models;

use yii\base\Model;
use yii\helpers\BaseFileHelper;
use common\models\User;

class Import extends Model
{
    const TITLES = [
        'occurrenceID', 'organismName', 'sex', 'lifeStage', 'basisOfRecord', 'locality', 'eventDate', 'identifiedBy', 'Is Empty',
        'SAIAB Number',    'Confidence', 'organismRemarks',
        'Container ID', 'Container_Type', 'PrepType', 'preparations', 'Date', 'InColection', 'Storage', 'occurrenceRemarks',
        'Scien Name', 'Individual Count', 'Site', 'Remarks', 'Identified By', 'Basis Of Record', 'Type Status', 'Qualifier', 'Confidence'
    ];

    public $file;
    public $log;

    private $path;
    private $iterator;
    private $matrix;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'maxFiles' => 1],
        ];
    }

    public function import()
    {
        if ($this->uploadFile()) {


            if (!$this->checkTitlesOfColumn()) {
                BaseFileHelper::unlink($this->path);
                return false;
            }
            if (!$this->readCSV()) {
                BaseFileHelper::unlink($this->path);
                return false;
            }

            $this->save();

            BaseFileHelper::unlink($this->path);
            return true;
        } else {
            BaseFileHelper::unlink($this->path);
            return false;
        }
    }

    private function uploadFile()
    {
        if ($this->file && $this->isCSV()) {
            $this->saveCSV();
            return true;
        } else {
            $this->log = 'File should be in csv format.';
            return false;
        }
    }

    private function isCSV()
    {
        return  $this->file->extension === 'csv' ? true : false;
    }

    private function saveCSV()
    {
        $time = time();
        $this->file->saveAs('uploads/' . $time . '.' . $this->file->extension);
        $this->path = 'uploads/' . $time . '.' . $this->file->extension;
    }

    private function readCSV()
    {
        $handle = fopen($this->path, "r");
        $this->iterator = 0;


        while (($fileop = fgetcsv($handle, 10000, ";")) !== false) {
            if ($this->iterator > 0) {
                $fileop = $this->stringValueToInteger($fileop);
                if ($fileop === false) return false;
                $row = $this->chekRow($fileop);
                if ($row[0] === false) {
                    $i = $this->iterator + 1;
                    $this->log = 'Error occurred in row <b>' . $i . '</b><br>' . $row[1];
                    return false;
                }
                $this->matrix[] = $fileop;
            }

            $this->iterator++;
        }

        return true;
    }

    private function checkTitlesOfColumn()
    {
        $fileop = $this->openCSV();
        $diff = array_diff($fileop, self::TITLES);
        if (empty($diff)) {
            return true;
        } else {
            $this->log = 'Titles of the column should be as in the example. ';
            return false;
        }
    }

    private function openCSV()
    {
        $handle = fopen($this->path, "r");
        return fgetcsv($handle, 1000, ";");
    }

    private function stringValueToInteger($row)
    {

        //host table
        if (($row[1] = $this->speciesId($row[1])) === false) {
            return $this->elementAbsent(1, 'Taxonomy');
        }
        if (($row[2] = $this->listId($row[2], 'sex', 'host')) === false) {
            return $this->elementAbsent(2, 'Lists');
        }
        if (($row[3] = $this->listId($row[3], 'age', 'host')) === false) {
            return $this->elementAbsent(3, 'Lists');
        }
        if (($row[4] = $this->listId($row[4], 'natureOfRecord', 'host')) === false) {
            return $this->elementAbsent(4, 'Lists');
        }
        if (($row[5] = $this->locationId($row[5])) === false) {
            return $this->elementAbsent(5, 'Locality');
        }
        if (($row[7] = $this->userId($row[7])) === false) {
            return $this->elementAbsent(7, 'User');
        }
        //container table
        if (($row[13] = $this->listId($row[13], 'containerType', 'container')) === false) {
            return $this->elementAbsent(13, 'Lists');
        }
        if (($row[14] = $this->listId($row[14], 'prepType', 'container')) === false) {
            return $this->elementAbsent(14, 'Lists');
        }
        if (($row[15] = $this->listId($row[15], 'fixative', 'container')) === false) {
            return $this->elementAbsent(15, 'Lists');
        }
        if (($row[18] = $this->storageId($row[18])) === false) {
            return $this->elementAbsent(18, 'Storage');
        }
        //sample table
        if (($row[20] = $this->speciesId($row[20])) === false) {
            return $this->elementAbsent(20, 'Taxonomy');
        }
        if (($row[22] = $this->listId($row[22], 'site', 'sample')) === false) {
            return $this->elementAbsent(22, 'Lists');
        }
        if (($row[24] = $this->userId($row[24])) === false) {
            return $this->elementAbsent(24, 'User');
        }
        if (($row[25] = $this->listId($row[25], 'basisOfRecord', 'sample')) === false) {
            return $this->elementAbsent(25, 'Lists');
        }
        if (($row[26] = $this->listId($row[26], 'typeStatus', 'sample')) === false) {
            return $this->elementAbsent(26, 'Lists');
        }
        return $row;
    }

    private function chekRow($fileop)
    {
        $host = $this->loadHostModel($fileop);
        $host->validate();
        $errors = $host->getFirstErrors();
        if (!empty($errors)) {
            return [false, $this->errorList($errors)];
        }

        $container = $this->loadContainerModel($fileop);
        $container->validate();
        $errors = $container->getFirstErrors();
        if (!empty($errors)) {
            return [false, $this->errorList($errors)];
        }

        $sample = $this->loadSampleModel($fileop);
        $sample->validate();
        $errors = $sample->getFirstErrors();
        if (!empty($errors)) {
            return [false, $this->errorList($errors)];
        }
    }

    private function errorList($errors)
    {
        $report = '';
        foreach ($errors as $erorr) {
            $report = $report . $erorr . '<br>';
        }
        return $report;
    }

    private function loadHostModel($row)
    {
        $host = new Host();
        $host->occurrenceID = $row[0];
        $host->sciName = $row[1];
        $host->sex = $row[2];
        $host->age = $row[3];
        $host->natureOfRecord = $row[4];
        $host->placeName = $row[5];
        $host->occurenceDate = $row[6];
        $host->determiner = $row[7];
        $host->isEmpty = $row[8];
        $host->sAIAB_Catalog_Number = $row[9];
        $host->idConfidence = $row[10];
        $host->comments = $row[11];
        return $host;
    }

    private function loadContainerModel($row)
    {
        $container = new Container();
        $container->scenario = Container::SCENARIO_CREATE;

        $container->containerId = $row[12];
        $container->containerType = $row[13] . '';
        $container->prepType = $row[14] . '';
        $container->fixative = $row[15] . '';
        $container->date = $row[16];
        $container->containerStatus = $row[17];
        $container->storage = $row[18];
        $container->comment = $row[19] . '';

        return $container;
    }

    private function loadSampleModel($row)
    {
        $sample = new Sample();
        $sample->scienName = $row[20];
        $sample->individualCount = $row[21];
        $sample->site = $row[22];
        $sample->remarks = $row[23];
        $sample->identifiedBy = $row[24];
        $sample->basisOfRecord = $row[25];
        $sample->typeStatus = $row[26];
        $sample->qualifier = $row[27];
        $sample->confidence = $row[28];

        return $sample;
    }

    private function speciesId($row)
    {
        if ($row) {
            $species = Taxonomy::find()->where(['scientificName' => $row])->one();
            return $species ? $species->id : false;
        }
    }

    private function userId($row)
    {
        if ($row) {
            $species = User::find()->where(['username' => $row])->one();
            return $species ? $species->id : false;
        }
    }

    private function locationId($row)
    {
        if ($row) {
            $location = Locality::find()->where(['localityName' => $row])->one();
            return $location ? $location->id : false;
        }
    }

    private function storageId($row)
    {
        if ($row) {
            $storage = Storage::find()->where(['item1' => $row])->one();
            return $storage ? $storage->id : false;
        }
    }

    private function listId($cell, $target, $table)
    {
        if ($cell) {
            $list = Service::find()->where(['value' => $cell])->andWhere(['target' => $target])->andWhere(['_table' => $table])->one();

            return $list ? $list->id : false;
        }
    }

    private function elementAbsent($index, $table_name)
    {
        $this->iterator++;
        $this->log = ' Error in row <b>' . $this->iterator . '</b>. Field ' . self::TITLES[$index] . ' is invalid. 
        Check the existence of the field in the ' . $table_name . ' table or check the spelling in the csv document.';
        return false;
    }

    private function save()
    {
        
        foreach ($this->matrix as $one) {
            $model = $this->loadHostModel($one);
            if (!$this->checkUniquenessHost($model->occurrenceID)) {
                $model->save(false);
            }
            if (!$model->isEmpty) {
                $model = $this->loadContainerModel($one);
                $model->parId = $one[0];
                if (isset($model->containerId)) {
                    if (!$this->checkUniquenessContainer($model->containerId)) {
                        $model->save(false);
                    }
                }
                $model = $this->loadSampleModel($one);
                if (isset($model->scienName)) {
                    $model->parId = $one[12];
                    $model->save(false);
                }
            }
        }
    }

    private function checkUniquenessHost($id)
    {

        return Host::find()->where(['occurrenceID' => $id])->one();
    }

    private function checkUniquenessContainer($id)
    {

        return Container::find()->where(['containerId' => $id])->one();
    }
}