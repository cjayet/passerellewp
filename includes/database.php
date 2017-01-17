<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:20
 */

class EasycontentDB {

    public $dbh;

    /**
     * EasycontentDB constructor.
     */
    public function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME , DB_USER, DB_PASS);
        }
        catch (Exception $e){
            echo "Erreur connexion : " . $e->getMessage();
        }
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function getOneRow($sql){
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchObject();
        return $row;
    }

    /**
     * @param $sql
     */
    public function executeSql($sql){

        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
        }
        catch (Exception $e){
            die('Error doing SQL : ' . $e->getMessage());
        }
    }


    /**
     * @param $data
     */
    public function registerCmsToEasycontent($data){
        // get site ?
        $site = $this->getSiteByDomain($data->site_domain);
        if (is_object($site) && is_numeric($site->id)){
            // site exists: update
            $this->updateEasyContentCmsToken($site->id, $data->jws_token);
        }
        else {
            // site not registered: add
            $this->addCmsToEasyContent($data);
        }

    }

    /**
     * @param $domain
     * @return mixed|string
     */
    protected function getSiteByDomain($domain){
        if (isset($domain) && $domain != ''){
            $sql = 'SELECT * 
                    FROM cms_usersettings
                    WHERE site_domain="'. $domain .'"';
            return $this->getOneRow($sql);
        }
        return '';
    }

    /**
     * Add site in Easycontent
     * @param $data
     */
    protected function addCmsToEasyContent($data){
        $sql = 'INSERT INTO cms_usersettings (site_domain, cms, access_token, created_at, updated_at)
              VALUES (
                "'. $data->site_domain .'",
                "'. $data->cms .'",
                "'. $data->jws_token .'",
                "'. date('Y-m-d H:i:s') .'",
                "'. date('Y-m-d H:i:s') .'"     
            )';
        $this->executeSql($sql);
    }

    /**
     * @param $idSite
     * @param $token
     */
    protected function updateEasyContentCmsToken($idSite, $token){
        $sql = 'UPDATE cms_usersettings
                        SET access_token = "'. $token .'"
                        WHERE id="'. $idSite .'"';
        $this->executeSql($sql);
    }
}