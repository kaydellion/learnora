<?php include "header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

`
               <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Site Settings</h5>
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="<?php echo $sitename; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Keywords</label>
                        <input type="text" name="site_keywords" class="form-control" value="<?php echo $sitekeywords; ?>">
                    </div>
                    
                <div class="mb-3">
                  <label class="form-label">Home Page Keywords</label>
                  <input type="text" name="default_keywords" class="form-control"
                        value="<?php echo htmlspecialchars($default_keywords); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">About Page Keywords</label>
                  <input type="text" name="aboutkey" class="form-control" 
                        value="<?php echo htmlspecialchars($aboutkey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Contact Page Keywords</label>
                  <input type="text" name="contactkey" class="form-control" 
                        value="<?php echo htmlspecialchars($contactkey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Privacy Policy Keywords</label>
                  <input type="text" name="privacykey" class="form-control" 
                        value="<?php echo htmlspecialchars($privacykey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Cookie Policy Keywords</label>
                  <input type="text" name="cookiekey" class="form-control" 
                        value="<?php echo htmlspecialchars($cookiekey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Terms & Conditions Keywords</label>
                  <input type="text" name="termskey" class="form-control" 
                        value="<?php echo htmlspecialchars($termskey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Why Us Page Keywords</label>
                  <input type="text" name="whyuskey" class="form-control" 
                        value="<?php echo htmlspecialchars($whyuskey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Disclaimer Page Keywords</label>
                  <input type="text" name="disclaimerkey" class="form-control" 
                        value="<?php echo htmlspecialchars($disclaimerkey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Blog Page Keywords</label>
                  <input type="text" name="blogkey" class="form-control" 
                        value="<?php echo htmlspecialchars($blogkey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Trainers Page Keywords</label>
                  <input type="text" name="trainerskey" class="form-control" 
                        value="<?php echo htmlspecialchars($trainerskey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Events by State Keywords</label>
                  <input type="text" name="statekey" class="form-control" 
                        value="<?php echo htmlspecialchars($statekey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Events by Month Keywords</label>
                  <input type="text" name="monthkey" class="form-control" 
                        value="<?php echo htmlspecialchars($monthkey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Events by Country Keywords</label>
                  <input type="text" name="countrykey" class="form-control" 
                        value="<?php echo htmlspecialchars($countrykey); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Events by Format Keywords</label>
                  <input type="text" name="formatkey" class="form-control" 
                        value="<?php echo htmlspecialchars($formatkey); ?>">
                </div>

                    <div class="mb-3">
                        <label class="form-label">Site URL</label>
                        <input type="url" name="site_url" class="form-control" value="<?php echo $siteurl; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Description</label>
                        <textarea name="site_description" class="form-control"><?php echo $sitedescription; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Logo</label>
                        <img src="<?php echo $siteurl;?>/uploads/<?php echo $siteimg; ?>" style="width: 20%; height: auto;" class="mb-2">
                        <input type="file" name="site_logo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Email</label>
                        <input type="email" name="site_mail" class="form-control" value="<?php echo $sitemail; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Phone Number</label>
                        <input type="text" name="site_number" class="form-control" value="<?php echo $sitenumber; ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Site Bank</label>
                      <input type="text" name="site_bank" class="form-control" value="<?php echo $site_bank; ?>"> 
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Site Account Number</label>
                      <input type="text" name="account_number" class="form-control" value="<?php echo $siteaccno; ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Affliate Percentage</label>
                      <input type="number" name="affiliate_percentage" class="form-control" value="<?php echo $affiliate_percentage; ?>">
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label">Commission Fee</label>
                      <input type="number" name="com_fee" class="form-control" value="<?php echo $escrowfee; ?>">
                    </div>
                 <div class="mb-3">
                      <label class="form-label">Payment Api key</label>
                      <input type="text" name="apikey" class="form-control" value="<?php echo $apikey; ?>">
                    </div>

                       <div class="mb-3">
                      <label class="form-label">Payment url text/live</label>
                      <input type="url" name="paymenturl" class="form-control" value="<?php echo $paymenturl; ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Site Account Name</label>
                      <input type="text" name="account_name" class="form-control" value="<?php echo $siteaccname; ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">TinyMCE key</label>
                      <input type="text" name="tinymce" class="form-control" value="<?php echo $tinymce; ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Google Map</label>
                      <input type="text" name="google_map" class="form-control" value="<?php echo $google_map; ?>">
                    </div>
                    <button type="submit" name="settings" value="course" class="btn btn-primary w-100">Update Settings</button>
                    </form>
                    </div>
                  </div>
                </div>

              </div>
            </div>


            <?php include "footer.php"; ?>
