      </div>
    <footer id="footer">
      <div class="bottomNav inner fw">
        <div class="col">
          <div class="menuTitle">О компании</div>
          <ul>
            <li><a href="">О нас</a></li>
            <li><a href="">Наши приемущества</a></li>
            <li><a href="">Сертификаты, лицензии</a></li>
            <li><a href="">Новости</a></li>
            <li><a href="">Партнерская программы</a></li>
            <li><a href="">Видео</a></li>
            <li><a href="">Фотогалерея</a></li>
            <li><a href="">История успеха</a></li>
            <li><a href="">Контакты</a></li>
          </ul>
        </div>
        <div class="col">
          <div class="menuTitle">О компании</div>
          <ul>
            <li><a href="">О нас</a></li>
            <li><a href="">Наши приемущества</a></li>
            <li><a href="">Сертификаты, лицензии</a></li>
            <li><a href="">Новости</a></li>
            <li><a href="">Партнерская программы</a></li>
            <li><a href="">Видео</a></li>
            <li><a href="">Фотогалерея</a></li>
            <li><a href="">История успеха</a></li>
            <li><a href="">Контакты</a></li>
          </ul>
        </div>
        <div class="col">
          <div class="menuTitle">О компании</div>
          <ul>
            <li><a href="">О нас</a></li>
            <li><a href="">Наши приемущества</a></li>
            <li><a href="">Сертификаты, лицензии</a></li>
            <li><a href="">Новости</a></li>
            <li><a href="">Партнерская программы</a></li>
            <li><a href="">Видео</a></li>
            <li><a href="">Фотогалерея</a></li>
            <li><a href="">История успеха</a></li>
            <li><a href="">Контакты</a></li>
          </ul>
        </div>
        <div class="col">
          <div class="menuTitle">О компании</div>
          <ul>
            <li><a href="">О нас</a></li>
            <li><a href="">Наши приемущества</a></li>
            <li><a href="">Сертификаты, лицензии</a></li>
            <li><a href="">Новости</a></li>
            <li><a href="">Партнерская программы</a></li>
            <li><a href="">Видео</a></li>
            <li><a href="">Фотогалерея</a></li>
            <li><a href="">История успеха</a></li>
            <li><a href="">Контакты</a></li>
          </ul>
        </div>
      </div>

      <div id="containerFooter" class="inner">
        <a href="" class="logoB"><img src="/i/logoB.png" alt=""></a>

        <div class="copyright">
          © 2014 Rinkost Markets <br>
          All rights reserved \ Все права зарегистрированы
        </div>

        <div class="socialF">
          <a href="" class="vk"></a>
          <a href="" class="fb"></a>
          <a href="" class="tw"></a>
        </div>
      </div>
    </footer>
    <div id="overlay" style="display: none;"></div>
    <div class="popup authH" style="display: none;">
      
      <?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
        "REGISTER_URL" => "/personal/",
        "FORGOT_PASSWORD_URL" => "/personal/?forgot_password=yes",
        "PROFILE_URL" => "/personal/",
        "SHOW_ERRORS" => "Y" 
        )
      );?>
    </div>
    <?if($APPLICATION->GetCurPage()=='/about-company/reviews/'):?>
    <div class="popup sendReview" style="display: none;" ng-controller="ctrlReview">
      <a class="popupClose" onclick="exit_call();">отмена</a>
      <form ng-submit="submit()" name="formReview" enctype="multipart/form-data">
        <label class="file_upload">
          <span id="fileformlabel">Загрузить фото</span>
          <input type="file" name="img" id="upload">
        </label>
        <div class="fright">
          <input type="text" ng-model="user.name" required placeholder="Логин или e-mail">
          <textarea ng-model="user.text" required placeholder="Ваш отзыв" rows="3"></textarea>
          <input type="submit" class="button pink" value="Оставить отзыв">
        </div>
      </form>
    </div>
    <?endif;?>
    <?if($APPLICATION->GetCurPage()=='/beginners/faq/'):?>
    <div class="popup sendQuestion" style="display: none;" ng-controller="ctrlQuestion">
      <a class="popupClose" onclick="exit_call();">отмена</a>
      <h2>Задать вопрос</h2>
      <?
      $userName = '';
      $userEmail = '';
      global $USER;
      if ( $USER->isAuthorized() ) {
        $userName = $USER->GetLastName().' '.$USER->GetFirstName();
        $userEmail = $USER->GetEmail();
      }
      ?>
      <form name="formQuestion" ng-submit="submit()" ng-init="user.name='<?=$userName?>';user.email='<?=$userEmail?>'">
        <input type="text" ng-model="user.name" required placeholder="Имя">
        <input type="text" ng-model="user.email" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/' required placeholder="E-mail">
        <textarea ng-model="user.text" required placeholder="Ваш вопрос" rows="3"></textarea>
        <input type="submit" class="button pink" value="Задать вопрос">
      </form>
    </div>
    <?endif;?>
  </div>

  <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
  <script>window.jQuery || document.write('<script src="/js/libs/jquery-2.0.3.min.js"><\/script>')</script>
  <!-- scripts concatenated and minified via ant build script-->
  <script type="text/javascript" src="/js/jquery.colorbox-min.js"></script>
  <script src="http://fotorama.s3.amazonaws.com/4.5.2/fotorama.js"></script>
  <script type="text/javascript" src="/js/jquery.formstyler.min.js"></script>
  <script type="text/javascript" src="/js/script.js"></script>
  <script type="text/javascript" src="/js/libs/angular.min.js"></script>
  <script type="text/javascript" src="/js/libs/ui-utils.min.js"></script>
  <script type="text/javascript" src="/js/controller.js"></script>
  <script type="text/javascript" src="/js/app.js"></script>
  <!-- end scripts-->
</body>
</html>