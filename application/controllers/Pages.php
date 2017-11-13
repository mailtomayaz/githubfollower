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

    public function view($page = 'home') {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['page_item'] = $this->page_model->get_page($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function searchuser($user='',$pg='') {
        //die('gttt');
        $data['title'] = 'Create a news item';
        //$this->form_validation->set_rules('title', 'Title', 'required');
       // $this->form_validation->set_rules('text', 'Text', 'required');
        $this->load->view('templates/header', $data);
        //$this->load->view('pages/home');
       // $this->load->view('templates/footer');
        //$username = trim($this->input->post('title'));
        //print_r($this->input->post());
        // Get cURL resource
       
        // Set some options - we are passing in a useragent too here
        $requestUrl='';
        $nextPage='';
        if($pg == ''){
           $requestUrl =  "https://api.github.com/search/users?q=$user";
        }else{
           // $requestUrl =  "https://api.github.com/search/users?q=$user";
            $requestUrl = "https://api.github.com/users/$user/followers?per_page=100&page=$pg";
        }
        //echo $requestUrl;
       // return $resp;     
       $resp = $this->makeApiCall($requestUrl);
//var_dump(json_decode($resp));
         $jsonData = json_decode($resp);
         //count
         $noOfFoll = count($jsonData);
         if($noOfFoll >= 100 ){
            $noOfFoll +=
            $nextUrl = "https://api.github.com/users/$user/followers?per_page=100&page=$pg";
            echo 'tehre are more folloers';
         }else{
             
         }
         //
         // print_r($jsonData->items[0]->login);
          $htmlData = '';
          if($pg == ''){
           echo $jsonData->items[0]->login;
          }else
          {
             // echo "<pre>";
                //print_r($jsonData);
             //   echo "</pre>";
             //   
          //get number of followers
          //pagination    
          $nCounter = count($jsonData);
          $readMore = $pg;
          
          if($nCounter >= 100){
              //echo 'Next repeat fetch nect record and ad page no';
              $readMore += 1;  
          }else{
              $readMore ='hide';
          } 
          //echo $this->makeApiCall('www.yahoo.com');
          $htmlData .= '<table>';
          $htmlData .= '<tr>';
          $htmlData .= '<th>Name</th>';
          $htmlData .= '<th>URL</th>';
          $htmlData .= '<th>Avatar</th>';
          $htmlData .= '</tr>';
                foreach($jsonData as $follData){
                   $htmlData .= '<tr>';
                    $htmlData  .= '<td>';
                    $htmlData  .= $follData->login;
                    $htmlData .= '</td>';
                    $htmlData  .= '<td><a href="';
                    $htmlData  .= $follData->html_url;
                    $htmlData .= '">'.$follData->html_url.'</a></td>';
                    $htmlData  .= '<td><img width="100" height="100" src="';
                    $htmlData  .= $follData->avatar_url;
                    $htmlData .= '"/></td>';
                    $htmlData .='</tr>';
         
                }
          $htmlData .= '<tr>';
          if($readMore!='hide'){
          $htmlData .= "<td><a page_no=$readMore id='showmore' href='#'>View More</a></td>";
          }
          $htmlData .= "<td>.$noOfFoll.</td>";
          //$htmlData .= '<th>Avatar</th>';
          $htmlData .= '</tr>';
          $htmlData .='</table>';
          }
         
       // echo "<pre>";
        //print_r(json_decode($resp));
        //echo "</pre>";
        //echo count($jsonData);
     
// Close request to clear up some resources
       
        echo $htmlData;
  // die('test');
//        if ($this->form_validation->run() === FALSE) {
//            $this->load->view('templates/header', $data);
//            $this->load->view('pages/home');
//            $this->load->view('templates/footer');
//        } else {
//            $this->page_model->check_user();
//            $this->load->view('pages/home');
//        }
    }
    public function makeApiCall($requestUrl){
        //echo $url;
         $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $requestUrl,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
// Send the request & save response to $resp
       // return $resp;
         $resp = curl_exec($curl);
         return $resp;
          curl_close($curl);
    }

}
