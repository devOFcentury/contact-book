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
     <div class="container">
          <h2>Ma Liste de contact</h2>
          <button class="add-contact">Ajouter</button>
          <div style="overflow-x: auto;">
               <table>
                    <thead>
                         <tr>
                              <th>Nom</th>
                              <th>Prénom</th>
                              <th>Categories</th>
                              <th>Action</th>
                              <th></th>
                         </tr>
                    </thead>
                    <tbody id="result">
                         
                    </tbody>
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
          });
     </script>
</body>

</html>