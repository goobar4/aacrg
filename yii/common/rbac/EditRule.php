<?php namespace common\rbac;

use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use frontend\models\Access;
use frontend\models\Taxonomy;
use frontend\models\TaxonomySearch;
use frontend\models\TaxonomyView;

/**
 * chek if user can edit profile
 */
class EditRule extends Rule
{
    public $name = 'canEdit';

    

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
                
        $res =Access::find()->where(['user_id'=>$user])->all();
        $taxon =Taxonomy::find()->where(['id'=>$params['id']])->one();
 
         switch ($taxon->rank) {
             case 7:
                 $r='species';
                 break;
             case 6:
                 $r = 'genus';
                 break;
             case 5:
                 $r='family';
                 break;
             case 4:
                 $r = 'order';
                 break;
             case 3:
                 $r ='class';
                 break;
             case 2:
                 $r = 'phylum';
                 break;
         }
       
        $arr = TaxonomySearch::findOne($r, $taxon->scientificName);
        //->where([$r=>$taxon->scientificName])->one();
        //$arr= $full_taxonomy->attributes;
        $j=0;
         
        foreach($arr as $a){
         $new_arr[$j] = $a;
         $j++;
        }
 
        for ($i=13-$taxon->rank; $i<12; $i++) {
         $new[$i] = $new_arr[$i];
        
       }
          
         
         foreach ($res as $re) {
 
           if(ArrayHelper::isIn($re->taxon_id, $new)){
               return $flag = true;
           }
         }

                  
        return isset($flag) ? $flag : false;
    }
}
