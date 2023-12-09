<?php

require './contact.class.php';


if (!empty($_POST['action']) and $_POST['action'] == 'fetch_contacts') {
     $contactInstance = new Contact();
     $error_db = null;
     try { 
          $contacts = $contactInstance->get_contacts();
          $result = "";
          if (count($contacts) > 0) {
               foreach($contacts as $contact) {
                    $result .= "
                         <tr class='see-contact-modal' key='{$contact['id']}'>
                              <td>{$contact['nom']} </td>
                              <td>{$contact['prenom']}</td>
                              <td>{$contact['numero']}</td>
                              <td>{$contact['email']}</td>
                              <td>{$contact['categorie']}</td>
                         </tr>
                    ";
               }
          } else {
               $result .= "
                    <tr>
                         <td align='center'>Data not Found</td>
                    </tr>
               ";
          }
     } catch (\Throwable $e) {
          $error_db = $e->getMessage();
     }

     if ($error_db) {
          echo json_encode([
               'status' => 422,
               'message' => "oups quelque chose s'est mal passée",
          ]);
     
          return false;
     }

     echo json_encode([
          'status' => 200,
          'message' => 'success',
          'data' => $result
     ]);

     return false;
}

if (!empty($_POST['action']) and $_POST['action'] == 'create') {
     $contactInstance = new Contact();
     $contactInstance->set_nom($_POST['nom']);
     $contactInstance->set_prenom($_POST['prenom']);
     $contactInstance->set_numero($_POST['numero']);
     $contactInstance->set_email($_POST['email']);
     $contactInstance->set_categorie($_POST['categorie']);
     $error_db = null;
     try {
          $contactInstance->add_contact();
     } catch (\Throwable $e) {
          $error_db = $e->getCode();
     }

     if ($error_db) {
          echo json_encode([
               'status' => 422,
               'message' => 'Cet adresse email existe déjà',
          ]);

          return false;
     }

     echo json_encode([
          'status' => 200,
          'message' => 'success',
     ]);

     return false;
}

if (!empty($_POST['action']) and $_POST['action'] == 'see') {
     if (isset($_POST['id'])) {
          $contactInstance = new Contact();
          $contactInstance->set_id((int) $_POST['id']);
          $error_db = null;
          try {
               
               $contact = $contactInstance->get_contact();
          } catch (\Throwable $e) {
               $error_db = $e->getMessage();
          }

          if ($error_db) {
               echo json_encode([
                    'status' => 422,
                    'message' => "oups quelque chose s'est mal passée."
               ]);
               return false;
          }
          
     }
     echo json_encode([
          'status' => 200,
          'message' => 'success',
          'data' => $contact
     ]);

     return false;
}

if (!empty($_POST['action']) and $_POST['action'] == 'edit') {
     if (isset($_POST['id'])) {
          $contactInstance = new Contact();
          $contactInstance->set_id((int) $_POST['id']);
          $error_db = null;
          try {
               
               $contact = $contactInstance->get_contact();
          } catch (\Throwable $e) {
               $error_db = $e->getMessage();
          }

          if ($error_db) {
               
               echo json_encode([
                    'status' => 422,
                    'message' => "OUPS quelque chose s'est mal passé",
               ]);
               
               return false;
          }

     }
     echo json_encode([
          'status' => 200,
          'message' => 'success',
          'data' => $contact
     ]);

     return false;
}

if (!empty($_POST['action']) and $_POST['action'] == 'update') {
     if (isset($_POST['id'])) {
          $contactInstance = new Contact();
          $contactInstance->set_nom($_POST['nom_edit']);
          $contactInstance->set_prenom($_POST['prenom_edit']);
          $contactInstance->set_numero($_POST['numero_edit']);
          $contactInstance->set_email($_POST['email_edit']);
          $contactInstance->set_categorie($_POST['categorie_edit']);
          $contactInstance->set_id($_POST['id']);
          $error_db = null;
          try {
               
               $contactInstance->update_contact();
          } catch (\Throwable $e) {
               $error_db = $e->getCode();
          }

          if ($error_db) {
               echo json_encode([
                    'status' => 422,
                    'message' =>"Cet adresse email existe déjà",
               ]);

               return false;
          }

     }

     echo json_encode([
          'status' => 200,
          'message' => 'success',
     ]);

     return false;
}