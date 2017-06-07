<?php
/**
 * @var array $issue
 */
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1">
                            <span class="glyphicon <?= $issue['state'] == 'open' ? 'glyphicon-exclamation-sign' : 'glyphicon-ok' ?> text-success"
                                  aria-hidden="true"></span>
                        </div>
                        <div class="col-md-10">
                            <a href="<?= Url::toRoute(['site/issue', 'repo' => $issue['repository']['name'], 'issueNum' => $issue['number']]) ?>"><?= $issue['title'] ?></a>
                            <?php foreach ($issue['labels'] as $label) { ?>
                                <span class="label label-default"
                                      style="background-color: #<?= $label['color'] ?>"><?= $label['name'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="col-md-1">
                            <span class="glyphicon glyphicon-comment"
                                  aria-hidden="true"></span><?= $issue['comments'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1">
                            #<?= $issue['id'] ?>
                            opened <?= Yii::$app->formatter->format($issue['created_at'], 'relativeTime') ?> by <a
                                    href="<?= $issue['user']['html_url'] ?>"
                                    target="_blank"><?= $issue['user']['login'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>