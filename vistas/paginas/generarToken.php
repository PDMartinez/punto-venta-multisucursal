    <main class="app-content">
   
      
          <div class="tile">
            <div class="tile-body">
              <form role="form" method="post">

                  <div class="row">
                    <div class="col-md-6">

                      
                      <div class="form-group">
                        <label class="control-label">Nombre de tabla:</label>
                       <input type="text" class="form-control input-lg" id="txtnombreTabla" name="txtnombreTabla" required>

                      </div>

                    </div>

                    <div class="col-md-6">
                    

                       <div class="form-group">
                        <label class="control-label">Nombre columna:</label>
                       <input type="text" class="form-control input-lg" id="txtnombreColumna" name="txtnombreColumna" required>

                      </div>
                   </div>

                      <div class="col-md-6">
                    

                       <div class="form-group">
                        <label class="control-label">Primari key columna:</label>
                       <input type="text" class="form-control input-lg" id="txtprimarikey" name="txtprimarikey" required>

                      </div>
                   </div>

         
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Procesar</button>

                      </div>
                          <?php
                            $crearApertura=new ControladorGenerarToken();
                            $crearApertura-> ctrCrearToken();
                           ?>
        

                  </div>
                  </form>
            </div>
          </div>
       
    </main>