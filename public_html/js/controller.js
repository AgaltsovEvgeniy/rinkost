'use strict';

var controller = {};

var outErr = function(msg){
  var msg = msg || 'Ошибка сервера. Попробуйте повторить попытку позже.';
  alert(msg);
}

// получить еще контента
controller.ctrlNextContent = function($scope, $http) {
  $scope.offset = 2;
  $scope.btShow = true;
  $scope.next = function(e){
    $http.post('/ajax/next-content.php', {type:'news', offset: $scope.offset}).success(function(res){
      if ( res.res ) {
        $scope.offset++;
        var page = document.querySelector('.newsListPage');
        page.innerHTML = page.innerHTML + res.data.html;
        $scope.btShow = res.data.more;
      } else { outErr(res.msg); }
    }).error(function(err){ outErr(); });
  }
}

// акции и бонусы
controller.ctrlNextPromotions = function($scope, $http) {
  $scope.offset = 2;
  $scope.btShow = true;
  $scope.next = function(e){
    $http.post('/ajax/next-content.php', {type:'promotions', offset: $scope.offset}).success(function(res){
      if ( res.res ) {
        $scope.offset++;
        var page = document.querySelector('.newsListPage');
        page.innerHTML = page.innerHTML + res.data.html;
        $scope.btShow = res.data.more;
      } else { outErr(res.msg); }
    }).error(function(err){ outErr(); });
  }
}

// отзывы
controller.ctrlNextReview = function($scope, $http) {
  $scope.offset = 2;
  $scope.btShow = true;
  $scope.next = function(e){
    $http.post('/ajax/next-content.php', {type:'reviews', offset: $scope.offset}).success(function(res){
      if ( res.res ) {
        $scope.offset++;
        var page = document.querySelector('.commentPage');
        page.innerHTML = page.innerHTML + res.data.html;
        $scope.btShow = res.data.more;
      } else { outErr(res.msg); }
    }).error(function(err){ outErr(); });
  }
}
controller.ctrlReview = function($scope, $http){
  angular.element(document).ready(function() {
    document.getElementById('upload').onchange = function(e) {
      var elem = e.target.files[0];
      var reader = new FileReader();
      reader.onload = function(event) {
        document.getElementById('fileformlabel').innerHTML = elem.name;
        $scope.user.img = event.target.result;
      };
      reader.readAsDataURL( elem );
    };
  });
  $scope.submit = function(){
    if ( $scope.formReview.$valid ) {
      $http.post('/ajax/review.php', $scope.user).success(function(res){
        if ( res.res ) {
          $('.sendReview form').html('<p>Ваш отзыв отправлен. Отзыв появится на сайте после модерации</p>');
        } else { alert(res.msg); }
      }).error(function(err){ alert('Ошибка сервера. Попробуйте повторить попытку позже.'); });
    }
  }
}
// комменты
controller.ctrlComment = function($scope, $http){
  $scope.commentsEvent = commentsEvent || [];
  $scope.offset = 2;
  $scope.btShow = true;
  $scope.next = function() {
    $http.post('/ajax/next-content.php', {type:'comments', section: $scope.user.section, offset: $scope.offset}).success(function(res){
      if ( res.res ) {
        $scope.offset++;
        $scope.commentsEvent = $scope.commentsEvent.concat(res.data.items);
        $scope.btShow = res.data.more;
      } else { outErr(res.msg); }
    }).error(function(err){ outErr(); });
  }
  $scope.submit = function(){
    if ( $scope.user.text ) {
      $http.post('/ajax/comment.php', $scope.user).success(function(res){
        if ( res.res ) {
          commentsEvent.unshift(res.comment);
          $scope.user.text = '';
          $scope.formComment.$setPristine();
        } else { alert(res.msg); }
      }).error(function(err){ alert('Ошибка сервера. Попробуйте повторить попытку позже.'); });
    }
  }
}

// Задать вопрос (faq)
controller.ctrlQuestion = function($scope, $http){
  $scope.submit = function(){
    if ( $scope.formQuestion.$valid ) {
      $http.post('/ajax/faq.php', $scope.user).success(function(res){
        if ( res.res ) {
          /* $scope.user.text = '';
          $scope.formQuestion.$setPristine(); */
          $('.sendQuestion form').html('<p>Ваш вопрос отправлен. Ответ появится на сайте после публикации</p>');
        } else { alert(res.msg); }
      }).error(function(err){ alert('Ошибка сервера. Попробуйте повторить попытку позже.'); });
    }
  }
}

// feedback
controller.ctrlFeedback = function($scope, $http){
  $scope.submit = function() {
    if ( $scope.formFeedback.$valid ) {
      $http.post('/ajax/feedback.php', $scope.user).success(function(res){
        if ( res.res ) {
          $scope.user = {};
          $scope.formFeedback.$setPristine();
        } else { outErr(); }
      }).error(function(err){ outErr(); });
    }
  }
}

// мои данные
controller.ctrlProfile = function($scope, $http, $timeout){
  $scope.btHide = false;
  $scope.text_save = 'Сохранить';
  $scope.submit = function() {
    if ( $scope.formProfile.$valid ) {
      $scope.user.country_id = document.getElementById('selectCountry').value;
      $scope.user.region_name = '';
      var region = document.getElementById('regionName') || false;
      if ( region ) { $scope.user.region_name = region.value; }
      $scope.btHide = true;
      $http.post('/ajax/personal/profile.php', $scope.user).success(function(res){
        if ( res.res ) {
          $scope.text_save = 'Сохранено';
          $timeout(function(){ $scope.text_save = 'Сохранить'; }, 2000);
        } else { outErr(res.msg); }
        $scope.btHide = false;
      }).error(function(err){ outErr(); });
    } else { outErr('Заполните все поля'); }
  }
  angular.element(document).ready(function() {
    document.getElementById('upload').onchange = function(e) {
      var elem = e.target.files[0];
      var reader = new FileReader();
      reader.onload = function(event) {
        //document.getElementById('fileformlabel').innerHTML = elem.name;
        document.getElementById('personalPhoto').setAttribute('src', event.target.result);
        $scope.user.img = event.target.result;
      };
      reader.readAsDataURL( elem );
    };
  });
}

// сменить пароль
controller.ctrlChangePass = function($scope, $http, $timeout){
  $scope.btHide = false;
  $scope.text_save = 'Изменить';
  $scope.msg = '';
  $scope.submit = function() {
    if ( $scope.formChangePass.$valid && $scope.user.pass == $scope.user.confirm_pass ) {
      $scope.btHide = true;
      $http.post('/ajax/personal/pass.php', $scope.user).success(function(res){
        if ( res.res ) {
          $scope.text_save = 'Изменено';
          $scope.user = {};
          $scope.msg = res.msg;
          $scope.formChangePass.$setPristine();
          $timeout(function(){
            $scope.text_save = 'Изменить';
            $scope.msg = '';
          }, 4000);
        } else { outErr(res.msg); }
        $scope.btHide = false;
      }).error(function(err){ outErr(); });
    }
  }
}