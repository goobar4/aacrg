<?php

namespace frontend\models;

use yii\data\SqlDataProvider;
use Yii;

class VialSearch extends yii\base\Model
{


    public $container;
    public $prepType;
    public $parasite;
    public $host;
    public $place;
    public $from;
    public $to;
    public $host_genus;
    public $host_family;
    public $host_order;
    public $host_class;
    public $host_phylum;
    public $parasite_genus;
    public $parasite_family;
    public $parasite_order;
    public $parasite_class;
    public $parasite_phylum;
    public $sex;
    public $age;
    public $province;
    public $country;


	

    public function rules()
    {
        return [

            [['container','prepType','parasite','host','place', 'from', 'to',
             'host_genus','host_family','host_order','host_class','host_phylum',
             'parasite_genus','parasite_family','parasite_order','parasite_class','parasite_phylum',
             'age', 'sex', 'province','country',
            ], 'trim']
        ];
    }


    public function search($params, $flag)
    {

       
        $this->load($params);

       
        $sql = "SELECT h.occurrenceID AS hostN, tax1.scientificName AS host,
        th2.scientificName AS speciesH, th3.scientificName AS genusH, th4.scientificName AS familyH, th5.scientificName AS orderH,
        th6.scientificName AS classH, th7.scientificName AS phylumH,
        se1.VALUE AS age, se2.VALUE AS sex,
        l.localityName AS place, se4.VALUE AS province, se5.VALUE AS country,
        l.decimalLatitude AS decimalLatitude, l.decimalLongitude AS decimalLongitude,
        h.occurenceDate AS date,
        c.containerId, se3.VALUE AS prepType,
        tax2.scientificName AS parasite, tax2.rank,
        tp2.scientificName AS speciesP, tp3.scientificName AS genusP, tp4.scientificName AS familyP, tp5.scientificName AS orderP,
        tp6.scientificName AS classP, tp7.scientificName AS phylumP,
        SUM(s.individualCount) AS individualCount
        FROM host h
        LEFT JOIN container c ON h.occurrenceID = c.parId
        LEFT JOIN sample s ON c.containerId = s.parId
        LEFT JOIN locality l ON h.placeName = l.id
        LEFT JOIN service se4 ON l.province = se4.id
        LEFT JOIN service se5 ON l.country = se5.id
        LEFT JOIN taxonomy tax1 ON h.sciName = tax1.id
        LEFT JOIN service se1 ON h.age = se1.id
        LEFT JOIN service se2 ON h.sex = se2.id
        LEFT JOIN service se3 ON c.prepType = se3.id
        LEFT JOIN taxonomy tax2 ON s.scienName = tax2.id
        
        LEFT JOIN taxonomy th2 ON h.sciName = th2.id AND th2.rank = 7
        LEFT JOIN taxonomy th3 ON IF(tax1.rank=6, h.sciName = th3.id, th2.parId = th3.id) AND th3.rank = 6 
        LEFT JOIN taxonomy th4 ON IF(tax1.rank=5, h.sciName = th4.id, th3.parId = th4.id) AND th4.rank = 5 
        LEFT JOIN taxonomy th5 ON IF(tax1.rank=4, h.sciName = th5.id, th4.parId = th5.id) AND th5.rank = 4
        LEFT JOIN taxonomy th6 ON IF(tax1.rank=3, h.sciName = th6.id, th5.parId = th6.id) AND th6.rank = 3
        LEFT JOIN taxonomy th7 ON IF(tax1.rank=2, h.sciName = th7.id, th6.parId = th7.id) AND th7.rank = 2
        
        LEFT JOIN taxonomy tp2 ON s.scienName = tp2.id AND tp2.rank = 7
        LEFT JOIN taxonomy tp3 ON IF(tax2.rank=6, s.scienName = tp3.id, tp2.parId = tp3.id) AND tp3.rank = 6 
        LEFT JOIN taxonomy tp4 ON IF(tax2.rank=5, s.scienName = tp4.id, tp3.parId = tp4.id) AND tp4.rank = 5
        LEFT JOIN taxonomy tp5 ON IF(tax2.rank=4, s.scienName = tp5.id, tp4.parId = tp5.id) AND tp5.rank = 4
        LEFT JOIN taxonomy tp6 ON IF(tax2.rank=3, s.scienName = tp6.id, tp5.parId = tp6.id) AND tp6.rank = 3
        LEFT JOIN taxonomy tp7 ON IF(tax2.rank=2, s.scienName = tp7.id, tp6.parId = tp7.id) AND tp7.rank = 2

        WHERE h.occurrenceID IS NOT NULL AND h.isDeleted<>1 and c.isDeleted<>1 And s.isDeleted<>1
        ";
       
       $param=null;
               
        if ($this->container) {
           $param[':container'] = $this->container.'%';
           $sql = $sql . ' AND c.containerId like :container';
        }
        if ($this->prepType) {
            $param[':prepType'] = $this->prepType.'%';
            $sql = $sql . ' AND se3.VALUE like :prepType';
         }
         if ($this->parasite) {
            $param[':parasite'] = $this->parasite.'%';
            $sql = $sql . ' AND tax2.scientificName like :parasite';
         }
         if ($this->host) {
            $param[':host'] = $this->host.'%';
            $sql = $sql . ' AND h.occurrenceID like :host';
         }
         if ($this->place) {
            $param[':place'] = $this->place.'%';
            $sql = $sql . ' AND l.localityName like :place';
         }
         if ($this->from) {
            $param[':from'] = $this->from;
            $sql = $sql . ' AND h.occurenceDate >= :from';
         }
         if ($this->to) {
            $param[':to'] = $this->to;
            $sql = $sql . ' AND h.occurenceDate <= :to';
         }

         if ($this->host_genus) {
            $param[':host_genus'] = $this->host_genus.'%';
            $sql = $sql . ' AND th3.scientificName like :host_genus';
         }
         if ($this->host_family) {
            $param[':host_family'] = $this->host_family.'%';
            $sql = $sql . ' AND th4.scientificName like :host_family';
         }
         if ($this->host_order) {
            $param[':host_order'] = $this->host_order.'%';
            $sql = $sql . ' AND th5.scientificName like :host_order';
         }
         if ($this->host_class) {
            $param[':host_class'] = $this->host_class.'%';
            $sql = $sql . ' AND th6.scientificName like :host_class';
         }
         if ($this->host_phylum) {
            $param[':host_phylum'] = $this->host_phylum.'%';
            $sql = $sql . ' AND th7.scientificName like :host_phylum';
         }
         if ($this->parasite_genus) {
            $param[':parasite_genus'] = $this->parasite_genus.'%';
            $sql = $sql . ' AND tp3.scientificName like :parasite_genus';
         }
         if ($this->parasite_family) {
            $param[':parasite_family'] = $this->parasite_family.'%';
            $sql = $sql . ' AND tp4.scientificName like :parasite_family';
         }
         if ($this->parasite_order) {
            $param[':parasite_order'] = $this->parasite_order.'%';
            $sql = $sql . ' AND tp5.scientificName like :parasite_order';
         }
         if ($this->parasite_class) {
            $param[':parasite_class'] = $this->parasite_class.'%';
            $sql = $sql . ' AND tp6.scientificName like :parasite_class';
         }
         if ($this->parasite_phylum) {
            $param[':parasite_phylum'] = $this->parasite_phylum.'%';
            $sql = $sql . ' AND tp7.scientificName like :parasite_phylum';
         }
         if ($this->sex) {
            $param[':sex'] = $this->sex.'%';
            $sql = $sql . ' AND se2.VALUE like :sex';
         }

         if ($this->age) {
            $param[':age'] = $this->age.'%';
            $sql = $sql . ' AND se1.VALUE like :age';
         }

         if ($this->province) {
            $param[':province'] = $this->province.'%';
            $sql = $sql . ' AND se4.VALUE like :province';
         }
         if ($this->country) {
            $param[':country'] = $this->country.'%';
            $sql = $sql . ' AND se5.VALUE like :country';
         }

      if ($flag == 1) {
         $sql = $sql . ' GROUP BY c.containerId, s.scienName';
      } elseif ($flag == 2) {
         $sql = $sql . ' GROUP BY  h.occurrenceID, s.scienName';
      }
       

        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ('.$sql.') tab', $param )->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $param,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'containerId',
                    'prepType',
                    'parasite',
                    'hostN',
                    'host',
                    'place',
                    'date',


                ],
            ],
        ]);     
   
        return $dataProvider;
    }
}
