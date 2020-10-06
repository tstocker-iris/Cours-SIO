<?php


class ApiRequest
{
    private $curl;
    private $url;
    private $options;
    private $address;

    public function __construct($url = '')
    {
        $this->curl = curl_init();
        $this->options = [];
        $this->url = $url;
        $this->address = '';
    }

    /**
     * Ajoute une option au tableau d'options $options
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Réinitialise le tableau d'options $options
     */
    public function clearOptions()
    {
        $this->options = [];
    }

    /**
     * Setter de la propriété @url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Setter de la propriété @address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Construit et renvoit l'url définitive
     * ex : https://geocode.xyz/address?json=1
     */
    private function buildUrl()
    {
        $url = $this->url . $this->address . "?";

        foreach ($this->options as $key => $value) {
            $url .= $key . '=' .$value . '&';
        }

        return $url;
    }

    /**
     * Fonction d'appel retournant un tableau associatif avec les données du webservice
     *
     * @return array Tableau associatif avec les données du webservice
     */
    public function call()
    {
        // set our url with curl_setopt()
        /**
         * Construction de l'url finale
         */
        $url = $this->buildUrl();
        echo 'Calling ' . $url . PHP_EOL;
        /**
         * Configuration de CURL avec l'url finale de notre appel
         */
        curl_setopt($this->curl, CURLOPT_URL, $url);

        // return the transfer as a string, also with setopt()
        /**
         * Configuration de CURL pour qu'il nous retourne bien une chaine de caractère
         */
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        /**
         * Appel au webservice
         */
        $output = curl_exec($this->curl);

        /**
         * Retour de fonction avec conversion de la chaine JSON en tableau associatif de données
         */
        return json_decode($output, TRUE);
    }
}