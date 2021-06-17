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
        th_genus.scientificName AS genusH, th_family.scientificName AS familyH,
        th_order.scientificName AS orderH, th_class.scientificName AS classH,
        th_phylum.scientificName AS phylumH,
       
        se1.VALUE AS age, se2.VALUE AS sex,
        l.localityName AS place, se4.VALUE AS province, se5.VALUE AS country,
        l.decimalLatitude AS decimalLatitude, l.decimalLongitude AS decimalLongitude,
        h.occurenceDate AS date,
        c.containerId, se3.VALUE AS prepType,
        tp_species.scientificName AS parasite,
        tp_genus.scientificName AS genusP, tp_family.scientificName AS familyP,
        tp_order.scientificName AS orderP, tp_class.scientificName AS classP,
        tp_phylum.scientificName AS phylumP,
       
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
       
       LEFT JOIN taxonomy_index tax_ind_p ON s.scienName = tax_ind_p.ID
       LEFT JOIN taxonomy tp_species ON tax_ind_p.id = tp_species.id
        LEFT JOIN taxonomy tp_genus ON tax_ind_p.genus = tp_genus.id
        LEFT JOIN taxonomy tp_family ON tax_ind_p.family = tp_family.id
        LEFT JOIN taxonomy tp_order ON tax_ind_p._order = tp_order.id
        LEFT JOIN taxonomy tp_class ON tax_ind_p.class = tp_class.id
        LEFT JOIN taxonomy tp_phylum ON tax_ind_p.phylum = tp_phylum.id       
       
        LEFT JOIN taxonomy_index tax_ind_h ON h.sciName = tax_ind_h.ID
        LEFT JOIN taxonomy th_species ON tax_ind_h.id = th_species.id
        LEFT JOIN taxonomy th_genus ON tax_ind_h.genus = th_genus.id
        LEFT JOIN taxonomy th_family ON tax_ind_h.family = th_family.id
        LEFT JOIN taxonomy th_order ON tax_ind_h._order = th_order.id
        LEFT JOIN taxonomy th_class ON tax_ind_h.class = th_class.id
        LEFT JOIN taxonomy th_phylum ON tax_ind_h.phylum = th_phylum.id

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
            $sql = $sql . ' AND tp_species.scientificName like :parasite';
         }
         if ($this->host) {
            $param[':host'] = $this->host.'%';
            $sql = $sql . ' AND th_species.scientificName like :host';
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
            $param[':host_genus'] =  $this->host_genus.'%';
            $sql = $sql . ' AND th_genus.scientificName like :host_genus';          
         }
         if ($this->host_family) {
            $param[':host_family'] = $this->host_family.'%';
            $sql = $sql . ' AND th_family.scientificName like :host_family';        
         }
         if ($this->host_order) {
            $param[':host_order'] = $this->host_order.'%';
            $sql = $sql . ' AND th_order.scientificName like :host_order';
         }
         if ($this->host_class) {
            $param[':host_class'] = $this->host_class.'%';
            $sql = $sql . ' AND th_class.scientificName like :host_class';
         }
         if ($this->host_phylum) {
            $param[':host_phylum'] = $this->host_phylum.'%';
            $sql = $sql . ' AND th_phylum.scientificName like :host_phylum';           
         }
         if ($this->parasite_genus) {
            $param[':parasite_genus'] = $this->parasite_genus.'%';
            $sql = $sql . ' AND tp_genus.scientificName like :parasite_genus';
         }
         if ($this->parasite_family) {
            $param[':parasite_family'] = $this->parasite_family.'%';
            $sql = $sql . ' AND tp_family.scientificName like :parasite_family';
         }
         if ($this->parasite_order) {
            $param[':parasite_order'] = $this->parasite_order.'%';
            $sql = $sql . ' AND tp_order.scientificName like :parasite_order';
         }
         if ($this->parasite_class) {
            $param[':parasite_class'] = $this->parasite_class.'%';
            $sql = $sql . ' AND tp_class.scientificName like :parasite_class';
         }
         if ($this->parasite_phylum) {
            $param[':parasite_phylum'] = $this->parasite_phylum.'%';
            $sql = $sql . ' AND tp_phylum.scientificName like :parasite_phylum';
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
