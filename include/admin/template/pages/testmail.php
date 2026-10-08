<?php
use App\classes\leemclasses;
use App\classes\mail;
use App\login\user;

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>

        <?php if(isset($_POST['teste']) || isset($_GET['true'])){
                $mail = new mail();
                
                if($mail->init()){
                echo '<h2 class="my-6 text-md font-semibold text-gray-700 dark:text-gray-200 ">Log<h2>';
                $mail->Maildebug();
                $mail->recipients(leemclasses::option('smtp_noreply'),leemclasses::option('site_title'),user::logged('email'),user::logged('name'),leemclasses::option('smtp_noreply'),leemclasses::option('smtp_noreply'),leemclasses::option('smtp_from'));
                $mail->content('SMTP Test Email',"<p>Your email settings in the ".leemclasses::option('site_name')." app are working!</p>","Your email settings in the ".leemclasses::option('site_name')." app are working!");
                $execute = $mail->send();
                if($execute['ok']){
                    echo '<div style="color:green;">Sucesso</div>';
                }else{
                        echo '<div style="color:red;">Fail</div>';
                }
                }else{
                        echo '<div style="color:red;">Erro ao conectar email</div>';
                }
                

        }?>
       
    </div>
</main>