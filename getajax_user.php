<?php
  include_once('config/Db.php');
  include_once('autoload.php');
  $userObj=User::getinstance();
  $baseURL = 'getajax_user.php'; 
  $limit = filter_var($_POST["limitset"], FILTER_VALIDATE_INT);
 if(isset($_POST["page"]) || isset($_POST["keywords"]) || isset($_POST["sortBy"]))
 {
    $offset = !empty($_POST["page"]) ?  filter_var($_POST["page"], FILTER_VALIDATE_INT) : 0 ;
    $wheresql="";
    $orderBy="";
    if(!empty($_POST["keywords"]))
    {
      $keyword=filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
      $wheresql="WHERE a.`view`='1' AND (a.`first_name` LIKE '%".$keyword."%' OR a.`last_name` LIKE '%".$keyword."%' OR b.`name` LIKE '%".$keyword."%' OR c.`name` LIKE '%".$keyword."%' OR d.`name` LIKE '%".$keyword."%')";
    }
    else
    {
      $wheresql="WHERE a.`view`='1'";
    }
    if(!empty($_POST["sortBy"]))
    {
      $keyword=filter_var($_POST["sortBy"], FILTER_SANITIZE_STRING);
      $orderbysql="ORDER BY a.`id` ".$keyword."";
    }
    else
    {
      $orderbysql="ORDER BY a.`id` DESC";
    }
    $totalRecords=$userObj->getTotalNumberOfRecordUserAjax($wheresql,$orderbysql);
    $allRecords=$userObj->getAllRecordsUserAjax($limit,$wheresql,$orderbysql,$offset);
    $pagConfig = array( 
            'baseURL' => $baseURL, 
            'totalRows' => $totalRecords["rowCount"], 
            'perPage' => $limit,
            'currentPage'=>$offset,
            'contentDiv' => 'postContent', 
            'link_func' => 'searchFilter' 
        );
    $paginationObj=new Pagination($pagConfig);
?>

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">S.No.</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">City</th>
                      <th class="text-center">State</th>
                      <th class="text-center">Country</th>
                      <th class="text-center">Created Date</th>
                       <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--====  display records ===-->
                    <?php
                        $i=$offset+1;
                        if(!empty($allRecords)):
                        foreach ($allRecords as $UserData)
                        {
                    ?>
                      <tr>
                          <td class="text-center"><?= $i++; ?>.</td>
                            <td class="text-center">
                              <?= ucwords($UserData["first_name"]." ".$UserData["last_name"]); ?>
                            </td>
                            <td class="text-center">
                              <?= $UserData["email"]; ?>
                            </td>
                            <td class="text-center">
                              <?= ucwords($UserData["city_name"]); ?>
                            </td>
                            <td class="text-center">
                              <?= ucwords($UserData["state_name"]); ?>
                            </td>
                            <td class="text-center">
                              <span class="text-primary"> (<?=$UserData["country_code"];?>) </span> <?= ucwords($UserData["country_name"]); ?>
                              
                            </td>
                            <td class="text-center">
                              <?= $UserData["pdate"]; ?>
                            </td>
                            <td class="text-center">
                              <div class="d-inline-flex">
                                <a href="javascript:void(0)" onclick="loaduserdata('<?= $UserData["id"];?>');" class="btn btn-dark btn-with-icon btn-block"><i class="fa fa-edit"></i> Edit</a>
                              </div>
                            </td>
                        </tr>
                  <?php } endif; ?>

                    <!--==== end display records ===-->
                  </tbody>
              </table>
                  <!-- Display pagination links -->
                  <?php echo $paginationObj->createLinks(); } ?>