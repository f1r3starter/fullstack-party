<?php
/**
 * PHP Version 7.0
 *
 * Issues Doc
 *
 * @category Class
 * @package  Models
 * @author   Andrii Filenko <andrey.filenko.official@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://localhost
 */

namespace app\models;

use Github\Client;

/**
 * Issues Class Doc
 *
 * @category Class
 * @package  Models
 * @author   Andrii Filenko <andrey.filenko.official@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://localhost
 */
class Issues
{
    /**
     * Class Issues
     *
     * @package  app\models
     * @property array $currentUser
     * @property array $states
     */
    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';
    /**
     * GitHub client
     *
     * @var Client
     */
    private $_client;
    private $_currentUser;
    public $states = [
        self::STATE_OPEN,
        self::STATE_CLOSED
    ];

    /**
     * Issues constructor.
     *
     * @param string $clientToken Github Token
     */
    public function __construct($clientToken)
    {
        $this->_client = new Client();
        $this->_client->authenticate($clientToken, null, Client::AUTH_HTTP_TOKEN);
        $this->_currentUser = $this->_client->currentUser()->show();
    }

    /**
     * Returns issues of the current user
     *
     * @param Issues ::STATE_OPEN|Issues::STATE_CLOSED $state State of issues
     *
     * @return array
     */
    public function getPage($state)
    {
        if (!in_array($state, $this->states)) {
            $state = Issues::STATE_OPEN;
        }
        return $this->_client
            ->currentUser()
            ->issues(['state' => $state]);
    }

    /**
     * Counts issues with specified state
     *
     * @param Issues ::STATE_OPEN|Issues::STATE_CLOSED $state State of issues
     *
     * @return int
     */
    public function getIssuesCount($state)
    {
        if (!in_array($state, $this->states)) {
            $state = Issues::STATE_OPEN;
        }
        return count(
            $this->_client
                ->currentUser()
                ->issues(['state' => $state])
        );
    }

    /**
     * Return specified issue
     *
     * @param int $issue Number of issue
     * @param string $repo Repo of issue
     *
     * @return array
     */
    public function getIssue($issue, $repo)
    {
        return $this->_client
            ->issue()
            ->show($this->_currentUser['login'], $repo, $issue);
    }

    /**
     * Returns comments for specified issue
     *
     * @param int $issue Number of issue
     * @param string $repo Repo of issue
     *
     * @return array
     */
    public function getComments($issue, $repo)
    {
        return $this->_client
            ->issue()
            ->comments()
            ->all($this->_currentUser['login'], $repo, $issue);
    }
}
