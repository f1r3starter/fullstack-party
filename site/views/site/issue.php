<?php
/**
 * @var array $issue
 * @var array $comments
 */
?>
<a href="/">Back to issues</a>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <?= $issue['title'] ?> #<?= $issue['id'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <span class="glyphicon <?= $issue['state'] == 'open' ? 'glyphicon-exclamation-sign' : 'glyphicon-ok'?> text-success" aria-hidden="true"></span>
                    opened <?= Yii::$app->formatter->format($issue['created_at'], 'relativeTime') ?> by <a
                        href="<?= $issue['user']['html_url'] ?>"
                        target="_blank"><?= $issue['user']['login'] ?></a> | <?= $issue['comments'] ?> <?=$issue['comments'] % 10 == 1 ? 'comment' : 'comments'?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($comments as $comment){?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <img style="width:50px;" src="<?=$comment['user']['avatar_url']?>" class="img-circle img-responsive"/>
                    </div>
                    <div class="col-md-4">
                        <a href="<?=$comment['user']['html_url']?>" target="_blank"><?=$comment['user']['login']?></a> commented <?= Yii::$app->formatter->format($comment['created_at'], 'relativeTime') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <?= nl2br($comment['body']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
