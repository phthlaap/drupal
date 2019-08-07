<?php

/**
 * @file
 * creation by: HuyTran
 */
namespace Drupal\subscribe\Controller;

use Drupal\Core\Controller\ControllerBase;

class Subscribe extends ControllerBase 
{
    public function list() 
    {
        $header = array(
            // We make it sortable by email.
            array('data' => $this->t('Email'), 'field' => 'email'),
            array('data' => $this->t('Create date'), 'field' => 'creation_date'),
          );
          $build['nome'] = array(
            '#type' => 'textfield',
            '#title' => t('Customer email'),
            '#size' => 15,
            '#default_value' => isset($form_state['storage']['nome']) ? 
                              $form_state['storage']['nome'] : '',
            );
            $build['submit'] = array(
            '#type' => 'submit',
            '#value' => t("Find"),  
            );
      
          $query = \Drupal::database()->select('mpire_subscribe', 'msub');
          $result = $query
          ->fields('msub', array('id', 'email', 'creation_date'));
          
          //For the pagination we need to extend the pagerselectextender and
          //limit in the query
          $pager = $result->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
          $results = $pager->execute()->fetchAll();
          // Populate the rows.
          $rows = array();
          foreach($results as $row) {
            $rows[] = array('data' => array(
              'email' => $row->email, 
              'creation_date' => $row->creation_date
            ));
          }
          // The table description.
          $build = array(
            '#markup' => t('List of All email user subscribe')
          );
      
          // Generate the table.
          $build['config_table'] = array(
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
          );
      
          // Finally add the pager.
          $build['pager'] = array(
            '#type' => 'pager'
          );
      
          return $build;
    }
}