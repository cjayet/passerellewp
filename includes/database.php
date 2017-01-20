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

            $stmt = $this->dbh->prepare('SELECT * 
                                            FROM cms_usersettings
                                            WHERE site_domain= :site_domain');
            $stmt->bindParam(':site_domain', $domain, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchObject();

        }
        return '';
    }

    /**
     * Add site in Easycontent
     * @param $data
     */
    protected function addCmsToEasyContent($data){

        $currentDate = date('Y-m-d H:i:s');
        $stmt = $this->dbh->prepare('INSERT INTO cms_usersettings (site_domain, cms, access_token, created_at, updated_at)
                                      VALUES (:site_domain, :cms, :access_token, :created_at, :updated_at)');
        $stmt->bindParam(':site_domain', $data->site_domain, PDO::PARAM_STR);
        $stmt->bindParam(':cms', $data->cms, PDO::PARAM_STR);
        $stmt->bindParam(':access_token', $data->jws_token, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $currentDate, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $currentDate, PDO::PARAM_STR);

        try {
            $stmt->execute();
        }
        catch (Exception $e){
            echo "Error in addCmsToEasyContent: ". $e->getMessage();
        }
    }

    /**
     * @param $idSite
     * @param $token
     */
    protected function updateEasyContentCmsToken($idSite, $token){
        $currentDate = date('Y-m-d H:i:s');
        $stmt = $this->dbh->prepare('UPDATE cms_usersettings
                                        SET access_token = :token,
                                            updated_at = :updated_at
                                        WHERE id= :idSite');
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $currentDate, PDO::PARAM_STR);
        $stmt->bindParam(':idSite', $idSite, PDO::PARAM_STR);

        try {
            $stmt->execute();
        }
        catch (Exception $e){
            echo "ERROR updateEasyContentCmsToken: ". $e->getMessage();
        }

    }
}