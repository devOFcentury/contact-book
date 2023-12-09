<?php

require './contact.class.php';


if (!empty($_POST['action']) and $_POST['action'] == 'fetch_contacts') {
     $contactInstance = new Contact();
     $contacts = $contactInstance->get_contacts();
     $result = "";

     if (count($contacts) > 0) {
          foreach($contacts as $contact) {
               $result .= "
                    <tr class='look-contact-modal' value='{$contact['id']}'>
                         <td>{$contact['nom']} </td>
                         <td>{$contact['prenom']}</td>
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

     $res = [
          'data' => $result
     ];

     echo json_encode($res);

     return false;
}

if (!empty($_POST['action']) and $_POST['action'] == 'create') {
     $contactInstance = new Contact();
     $contactInstance->set_nom($_POST['nom']);
     $contactInstance->set_prenom($_POST['prenom']);
     $contactInstance->set_categorie($_POST['categorie']);
     $contactInstance->add_contact();

     return false;
}