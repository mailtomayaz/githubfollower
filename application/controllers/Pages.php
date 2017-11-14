<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
        $this->load->model('page_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    
    /**
     * This is default method to view static pages
     * @param string $page name of page like home and about us
     * @return array of page data
     */

    public function view($page = 'home') {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title']      = ucfirst($page); // Capitalize the first letter
        $data['page_item']  = $this->page_model->get_page($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    
    
    /**
     * This mehtod will query the github user for his data and his follower data
     * @param string $user
     * @param integer $page for pagination of followers
     * @return string all data of user and followers as select with per page
     */

    public function searchuser($user = '', $page = '') {
        $data['title'] = 'Create a news item';
        $this->load->view('templates/header', $data);
        // Get cURL resource
        // Set some options - we are passing in a useragent too here
        $requestUrl = '';
        $nextPage = '';
        $perPage = 3;
        if ($page == '') {

            $requestUrl = "https://api.github.com/users/$user?client_id=71e6fed3ec0de9f1b18f&client_secret=ee5951f5916e469a632a4aacc04aac178dfa73f8";
        } else {

            $requestUrl = "https://api.github.com/users/$user/followers?client_id=71e6fed3ec0de9f1b18f&client_secret=ee5951f5916e469a632a4aacc04aac178dfa73f8&per_page=$perPage&page=$page";
        }
        //make php curl call to API
        $resp = $this->makeApiCall($requestUrl);
        //decode json data
        $jsonData = json_decode($resp);
        //error hanling
        if (isset($jsonData->message)) {
            echo $jsonData->message;
        } else {
            //make data for frontvew
            $htmlData = '';
            if ($page == '') {
                $htmlData .='<table>';
                $htmlData .= '<tr><td><div class="handle"> Handle :<b> ' . $jsonData->login . '</b></div></td>';
                $htmlData .= '<td><div class="followers">  Followers:<b> ' . $jsonData->followers . '</b></div></td></tr>';
                $htmlData .='</table>';
                
            } else {

                //get number of followers
                //pagination  view more option logic
                $nCounter = count($jsonData);
                $readMore = $page;

                if ($nCounter >= $perPage) {

                    $readMore += 1;
                } else {
                    $readMore = 'hide';
                }


                foreach ($jsonData as $follData) {
                    $htmlData .= '<tr>';
                    $htmlData .= '<td>';
                    $htmlData .= $follData->login;
                    $htmlData .= '</td>';
                    $htmlData .= '<td><a href="';
                    $htmlData .= $follData->html_url;
                    $htmlData .= '">' . $follData->html_url . '</a></td>';
                    $htmlData .= '<td><img width="100" height="100" src="';
                    $htmlData .= $follData->avatar_url;
                    $htmlData .= '"/></td>';
                    $htmlData .= '</tr>';
                    
                }
                
                $htmlData .= '<tr>';
                
                if ($readMore != 'hide') {
                    $htmlData .= "<td><button class='showmore' page_no=$readMore id='showmore' href='#'>Load More</button></td>";
                }
                
                $htmlData .= '</tr>';
               // $htmlData .= '</table>';
                
            }

            echo $htmlData;
        }
    }

    /**
     * function to make API call
     * 
     * @param string  $requestUrl API url with all arguments
     * @return jsonobject
     */
    public function makeApiCall($requestUrl) {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $requestUrl,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        
        //Send the request & save response to $resp
        // return $resp;
        $resp = curl_exec($curl);
        curl_close($curl);
         
        return $resp;
    }

}
