<?php
/**
 * @file
 * Created by IntelliJ IDEA.
 * User: pc07
 * Date: 11/06/2019
 * Time: 12:12
 */
namespace Drupal\subscribe\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class SubscribeForm extends FormBase
{

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'subscribe';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#theme'] = 'subscribe';
    $form['massage'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];
    $form['email'] = [
      '#type' => 'email',
      '#attributes' => array('class' => array('vt-input vt-body-1'), 'placeholder' => [$this->t('Enter your email')]),
      '#default_value' => "",
      '#required' => TRUE,
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'button',
      '#attributes' => array('class' => array('vt-btn-form')),
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::setMessage',
      ]
    ];
    $form['#no_cache'] = TRUE; 
    $form_state->setRebuild(true);
    return $form;

  }

  /**
   * Setting the message in our form.
   */
  public function setMessage(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $email = $form_state->getValue('email');
    if (!(valid_email_address($email))) {
      $response->addCommand(
        new HtmlCommand(
          '.result_message',
          '<div style="color:red" class="my_top_message">' . t('The email address @result', ['@result' => $email . ' is not valid']) . '</div>'
        )
      );
    } else {
      $conn = Database::getConnection();
      $conn->insert('mpire_subscribe')->fields(
        array(
          'email' => $form_state->getValue('email'),
        )
      )->execute();
      
      $response->addCommand(
        new HtmlCommand(
          '.result_message',
          '<div style="color:green" class="my_top_message">' . t('The results is @result', ['@result' => 'Success']) . '</div>'
        )
      );
    }
    $response->addAttachments($form['#attached']);
    
    return $response;
  }
  
  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    
  }

}