<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 14:39
 */

namespace service;

use domain\Agent;
use dao\AgentDAO;
use http\HTTPException;
use http\HTTPStatusCode;

/**
 * @access public
 * @author andreas.martin
 */
class AuthServiceImpl implements AuthService {
    /**
     * @AttributeType AuthServiceImpl
     */
    private static $instance = null;
    /**
     * @AttributeType int
     */
    private $currentAgentId;

    /**
     * @access public
     * @return AuthServiceImpl
     * @static
     * @ReturnType AuthServiceImpl
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @access protected
     */
    protected function __construct() { }

    /**
     * @access private
     */
    private function __clone() { }

    /**
     * @access public
     * @return boolean
     * @ReturnType boolean
     */
    public function verifyAuth() {
        if(isset($this->currentAgentId))
            return true;
        return false;
    }

    /**
     * @access public
     * @return int
     * @ReturnType int
     */
    public function getCurrentAgentId()
    {
        return $this->currentAgentId;
    }

    /**
     * @access public
     * @param String email
     * @param String password
     * @return boolean
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function verifyAgent($email, $password) {
        $agentDAO = new AgentDAO();
        $agent = $agentDAO->findByEmail($email);
        if (isset($agent)) {
            if (password_verify($password, $agent->getPassword())) {
                if (password_needs_rehash($agent->getPassword(), PASSWORD_DEFAULT)) {
                    $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $agentDAO->update($agent);
                }
                $this->currentAgentId = $agent->getId();
                return true;
            }
        }
        return false;
    }

    /**
     * @access public
     * @return Agent
     * @ReturnType Agent
     * @throws HTTPException
     */
    public function readAgent() {
        if($this->verifyAuth()) {
            $agentDAO = new AgentDAO();
            return $agentDAO->read($this->currentAgentId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    /**
     * @access public
     * @param string name
     * @param String email
     * @param String password
     * @return boolean
     * @ParamType name string
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function editAgent($name, $email, $password) {
        $agent = new Agent();
        $agent->setName($name);
        $agent->setEmail($email);
        $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $agentDAO = new AgentDAO();
        if($this->verifyAuth()) {
            $agent->setId($this->currentAgentId);
            if($agentDAO->read($this->currentAgentId)->getEmail() !== $agent->getEmail()) {
                if (!is_null($agentDAO->findByEmail($email))) {
                    return false;
                }
            }
            $agentDAO->update($agent);
            return true;
        }else{
            if(!is_null($agentDAO->findByEmail($email))){
                return false;
            }
            $agentDAO->create($agent);
            return true;
        }
    }

    /**
     * @access public
     * @param String token
     * @return boolean
     * @ParamType token String
     * @ReturnType boolean
     */
    public function validateToken($token) {
        $tokenArray = explode(":", $token);
        if(count($tokenArray)>1) {
            $this->currentAgentId = $tokenArray[0];
            return true;
        }
        return false;
    }

    /**
     * @access public
     * @param int type
     * @param String email
     * @return String
     * @ParamType type int
     * @ParamType email String
     * @ReturnType String
     */
    public function issueToken($type = self::AGENT_TOKEN, $email = null) {
        return $this->currentAgentId .":". bin2hex(random_bytes(20));
    }
}