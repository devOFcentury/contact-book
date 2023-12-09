<?php
require './contact.class.php';
$contact_instance = new Contact();
$contacts = $contact_instance->get_contacts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Contact Book</title>
     <link rel="stylesheet" href="style.css">
</head>

<body>
     <!-- modal d'ajout de contact -->
     <div id="modal-create">
          <div class="modal-create__modal-content">
               <span class="close-modal-create">&times;</span>
               <p>Create Modal</p>
          </div>
     </div>

     <!-- modal vue sur contact -->
     <div id="modal-view">
          <div class="modal-view__modal-content">
               <span class="close-modal-view">&times;</span>
               <p>View Modal</p>
          </div>
     </div>

     <!-- modal d'édition de contact -->
     <div id="modal-edit">
          <div class="modal-edit__modal-content">
               <span class="close-modal-edit">&times;</span>
               <p>Edit Modal</p>
          </div>
     </div>

     <div class="container">
          <h2>Ma Liste de contact</h2>
          <button class="add-contact-modal">Ajouter</button>
          <div style="overflow-x: auto;">
               <table>
                    <thead>
                         <tr>
                              <th>Nom</th>
                              <th>Prénom</th>
                              <th>Categories</th>
                         </tr>
                    </thead>
                    <tbody id="result"></tbody>
               </table>
          </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script>
          $(function() {
               $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: {action: 'fetch_contacts'},
                    success: function (response) {
                         var res = $.parseJSON(response);
                         $('#result').html(res.data);
                    }
               });
               
               // toggle create modal
               $('.add-contact-modal').on('click', function() {
                    $('#modal-create').show('slow');
                    $('.close-modal-create').on('click', function() {
                         $('#modal-create').hide('slow');
                    });
               });
               
          });

          // toggle view modal
          $(document).on('click', '.look-contact-modal', function() {
               $('#modal-view').show('slow');
               $('.close-modal-view').on('click', function() {
                    $('#modal-view').hide('slow');
               });
          });

          
     </script>
</body>

</html>