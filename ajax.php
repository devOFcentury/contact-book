<?php

require './contact.class.php';


if (!empty($_POST['action']) and $_POST['action'] == 'fetch_contacts') {
     $contactInstance = new Contact();
     $contacts = $contactInstance->get_contacts();
     $result = "";

     if (count($contacts) > 0) {
          foreach($contacts as $contact) {
               $result .= "
                    <tr>
                         <td>{$contact['categorie']} </td>
                         <td>{$contact['prenom']}</td>
                         <td>{$contact['categorie']}</td>
                         <td><button type='button' value='{$contact['id']}'>Voir</button></td>
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