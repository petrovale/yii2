<?php
use yii\helpers\Html;
//use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
?>
<h1>Countries</h1>
<ul>
<?php echo Yii::t('app','Top Books')  ?></h2>

                <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_post',
                ]); ?>
</ul>

