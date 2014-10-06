    </main>
  </div>
  <div class="clear"></div>
  <?include $_SERVER['DOCUMENT_ROOT'].'/include/openLinks.php';?>
  <?
  if ( preg_match('/^\/personal\//', $_SERVER['REQUEST_URI']) ) {
    include $_SERVER['DOCUMENT_ROOT'].'/include/paymentSistems.php';
  }?>
  <?include $_SERVER['DOCUMENT_ROOT'].'/include/apps.php';?>
</div>

<?include $_SERVER['DOCUMENT_ROOT'].'/include/footer.php';?>