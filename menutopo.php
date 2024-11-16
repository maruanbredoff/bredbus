<?php
if($_SESSION['UsuarioNivel'] != 1) {
?>                         
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item">
                                        <?php if($total2 > 0){
                                        ?>
                                        <a class="nav-link" href="cliente_anamnese_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-stethoscope"></i>Anamnese</a>      
                                    <?php 
                                    } else {?>
                                        <a class="nav-link" href="cliente_anamnese.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-stethoscope"></i>Anamnese</a> <?php }?>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_imagens.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-image-album"></i> Imagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_receitas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-bulletin-board"></i>Receitas</a>
                                      </li>
                                    </ul>
<?php } 
else {?>
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item">
                                        <?php if($total2 > 0){
                                        ?>
                                        <a class="nav-link" href="cliente_anamnese_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-stethoscope"></i>Anamnese</a>      
                                    <?php 
                                    } else {?>
                                        <a class="nav-link" href="cliente_anamnese.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-stethoscope"></i>Anamnese</a> <?php }?>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>
<?php } ?>
