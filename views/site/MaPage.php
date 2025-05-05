
<h1><?php echo $message; ?></h1>
<pre>
<p><?php print_r($List);?> </p>
</pre>

<p> Liste déroulante:
   <?php
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    // $List est un tableau associatif, on va le transformer en un autre où: la clé est la valeur ,et la valeur est l'étiquette affichée
    // ArrayHelper::map($array, $clédansAnc, $valeurDansAnc, $groupField = null)
    $TabMap = ArrayHelper::map($List, 'id', 'fruit');

    //Html::dropDownList($nomChamps, $valeurParDft, $TabMap, $unTaleau optionnel pour personnliserSelect)
    echo Html::dropDownList('fruits', null, $TabMap, ['prompt' => 'Sélectionnez un fruit']); // 'fruits' est le nom du champ  
   ?>
</p>
