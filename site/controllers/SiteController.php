<?php
/**
 * PHP Version 7.0
 *
 * SiteController Doc
 *
 * @category Class
 * @package  Controllers
 * @author   Andrii Filenko <andrey.filenko.official@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://localhost
 */

namespace app\controllers;

use app\models\Issues;
use Github\Exception\RuntimeException;
use Yii;
use yii\authclient\clients\GitHub;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

/**
 * SiteController Class Doc
 *
 * @category Class
 * @package  Controllers
 * @author   Andrii Filenko <andrey.filenko.official@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://localhost
 */
class SiteController extends Controller
{
    const PER_PAGE = 4;
    const SESSION_TOKEN = 'githubToken';

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'app\filters\IssueFilter',
                'only' => ['issues', 'issue']
            ],
        ];
    }

    /**
     * Actions
     *
     * @return array
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Index page
     *
     * @return string|yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->getSession()->get(self::SESSION_TOKEN)) {
            return $this->redirect('site/issues');
        } else {
            return $this->render('index');
        }
    }

    /**
     * OAuth callback
     *
     * @param GitHub $client Client
     *
     * @return \yii\web\Response
     */
    public function onAuthSuccess($client)
    {
        Yii::$app->session->set(
            self::SESSION_TOKEN,
            $client->getAccessToken()->getToken()
        );
        return $this->redirect(Url::toRoute('site/issues'));
    }

    /**
     * All issues
     *
     * @param string $state Issue state
     *
     * @return string
     */
    public function actionIssues($state = Issues::STATE_OPEN)
    {
        $issuesModel = new Issues(Yii::$app->params[self::SESSION_TOKEN]);
        $dataProvider = new ArrayDataProvider(
            [
                'allModels' => $issuesModel->getPage($state),
                'pagination' => [
                    'pageSize' => self::PER_PAGE,
                ],
            ]
        );
        $buttons = [];
        foreach ($issuesModel->states as $state) {
            $url = Url::toRoute(['site/issues', 'state' => $state]);
            $buttons[] = [
                'label' => sprintf(
                    "%s %d",
                    $state,
                    $issuesModel->getIssuesCount($state)
                ),
                'options' => [
                    'onclick' => "location.href='$url'"
                ]
            ];
        }
        return $this->render(
            'issues', [
                'issues' => $dataProvider,
                'buttons' => $buttons
            ]
        );
    }

    /**
     * Single issue with comments
     *
     * @param string $repo     Repository name
     * @param int    $issueNum Issue number
     *
     * @return string
     */
    public function actionIssue($repo, $issueNum)
    {
        $issuesModel = new Issues(Yii::$app->params[self::SESSION_TOKEN]);
        try {
            return $this->render(
                'issue', [
                    'issue' => $issuesModel->getIssue($issueNum, $repo),
                    'comments' => $issuesModel->getComments($issueNum, $repo)
                ]
            );
        } catch (RuntimeException $e) {
            return 'No issue found with specified repository name and issue number.';
        }
    }

    /**
     * Logout
     *
     * @return yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getSession()->remove(self::SESSION_TOKEN);
        return $this->redirect('/');
    }
}
