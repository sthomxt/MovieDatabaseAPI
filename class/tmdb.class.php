<?php
// include MYSQL Class
include 'mysql.class.php';

class TMBD {
    
    public const APIURL = "http://api.themoviedb.org/3/";
    public const APIKEY = ""; // to do: add TMDB APIKey

    // to do: update DB Info
    private const DB_SERVER='';
    private const DB_USER='';
    private const DB_PASSWORD='';
    private const DB_PORT='';

    private $method;
    private $type;
    private $input;
    private $url;

    public function run_search($method, $type, $input) {
        // access API for search
        $this->set_vars($method, $type, $input);

        // create form data
        $data = array(
            'query' => $input,
        );

        // Create and send URL data to API, method=search
        $query = http_build_query($data);
        $this->url = self::APIURL.$this->method.$this->type.'?api_key='.self::APIKEY.'&'.$query;
        
        return $this->send_data($method);
    }

    public function get_details($method, $type, $input) {
        // access API to retrieve details
        $this->set_vars($method, $type, $input);

        // Create and send URL data to API, method=detail
        $this->url = self::APIURL.$this->type.'/'.$this->input.'?api_key='.self::APIKEY;

        return $this->send_data($method);
    }

    public function send_data($method) {

        // Get API data from tmdb
        $response = file_get_contents($this->url);
        
        // Store API data to array 
        $array = json_decode($response,true);

        // Strip unneeded data from object
        $tmdb_info = [];
        if ($method=='search') {   
            $api_data = $array['results'];
            $count = 0;
            foreach ( $api_data as $key => $value) {
                // this can be trimmed only collecting needed data
                $tmdb_info[$count] = [
                    'id' => (string)$value['id'],
                    'title' => $value['title'],
                    'year' => (string)date("Y", strtotime($value['release_date'])),
                    'poster_path' => $value['poster_path'],
                    'overview' => $value['overview']
                ];
                $count++;
                if ($count>=10) { break; }  
            }
            // to do: save analytics to MYSQL DB
            // $db = new MYSQL(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB_PORT);
            // $db->db_save((string)$this->input, (string)$_SERVER['REMOTE_ADDR']) ;
        }  else {
            // this was added as 1 field (genre) is a separate API call
            // for later optimization
            $value = $array;
            // error check for missing genres
            $genre = (!empty($value['genres'][0]))?(string)$value['genres'][0]['name']:'';
            $tmdb_info[0] = [
                'id' => (string)$value['id'],
                'title' => (string)$value['title'],
                'year' => (string)date("Y", strtotime($value['release_date'])),
                'genre' => $genre,
                'poster_path' => (string)$value['poster_path'],
                'overview' => (string)$value['overview']
            ];
        }
        
        // Send desired info as JSON 
        $JSON_out = json_encode($tmdb_info);

        return $JSON_out;
    }

    private function set_vars($method, $type, $input) {
        // store send data variables
        $this->method = (!empty($method)) ? $method.'/' : '';
        $this->type = (!empty($type)) ? $type.'/' : '';
        $this->input = $input;
    }

}