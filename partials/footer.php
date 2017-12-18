
                              <!--Fin Contenido-->
                           </div>
                        </div>
                        
                      </div>
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy;  <a href="#">Alcaldia Municipio Sucre 2017-2018</a>.</strong> Todos los Derechos Reservados.
        <!-- jQuery 2.1.4 -->
        <script src="<?= $_SESSION['base_url1'].'/assets/js/jQuery-2.1.4.min.js' ?>"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?= $_SESSION['base_url1'].'/assets/js/bootstrap.min.js' ?>"></script>
        <!-- AdminLTE App --> 
        <script src="<?= $_SESSION['base_url1'].'/assets/js/app.min.js' ?>"></script>
        <!--Datatables -->
        <script src="<?= $_SESSION['base_url1'].'/assets/js/jquery.dataTables.js'    ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'/assets/js/dataTables.bootstrap.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'/assets/js/bootstrap-datepicker.js' ?>"></script>";
        <script src="<?= $_SESSION['base_url1'].'/assets/js/bootstrap-datepicker.es.min.js' ?>"></script>
      </footer>
  </body>
</html>
<script>
  $(function(){
    $('.date-picker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      language: 'es'
    })
  })
</script>