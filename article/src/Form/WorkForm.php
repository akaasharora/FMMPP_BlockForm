<?php
/**
 * @file
 * Contains \Drupal\resume\Form\WorkForm.
 */
namespace Drupal\article\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class WorkForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'work_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['location'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter your postal code or address:'),
      '#required' => TRUE,
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Find'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

      $postal_code = $form_state->getValues()['location'];
      if ($postal_code=='') {
          drupal_set_message("Cannot be empty! Please enter your Postal Code or Address.");

      }else{
          $operation = $form_state->getValues()['op']->__toString();
          $geo_code = $this->convertPostalToGeo($postal_code);
          $riding_array = $this->getRiding($geo_code);
          $riding = $riding_array[0];// Final Riding
          drupal_set_message("You entered " . $postal_code . ". Your Riding is : " . $riding);

      }

    //drupal_set_message($this->t('You entered: @location ', array('@location ' => $form_state->getValue('location'))));

  }
    public function convertPostalToGeo($postal_code) {
        // code
        $address = urlencode($postal_code);
        $key ='AIzaSyD0FH0qHadaGu0z63zzfCd_i0Mgb1KCzgU';
        $geoQuery = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
        $content = file_get_contents($geoQuery);
        $content_array = json_decode($content,true);
        $lat = $content_array['results'][0]['geometry']['location']['lat'];
        $lng = $content_array['results'][0]['geometry']['location']['lng'];
        $ret = 'Lat:' . $lat . " Lng: ". $lng;
        return $lat.','.$lng ;
    }
    public function getRiding($geo_code){
        $contains = urlencode($geo_code);
        $openNorthQuery = 'http://represent.opennorth.ca/boundaries/?contains=' . $contains;
        $query_content = file_get_contents($openNorthQuery);
        $query_content_array = json_decode($query_content, true);
        // $riding = $query_content_array['objects'][0]['name'];

        $riding_array = [];
        $riding = '';
        $ctr = 0;
        for ($j = 0; $j < count($query_content_array['objects']); $j++) {
            if ($query_content_array['objects'][$j]['boundary_set_name'] == 'Ontario electoral district') {

                $riding_array[$ctr] = $query_content_array['objects'][$j]['name'];
                $ctr++;
                //$riding = $query_content_array['objects'][0]['name'];
            }

        }
        return $riding_array;
        //return $riding;
    }
}