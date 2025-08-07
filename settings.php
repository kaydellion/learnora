
<?php 
include "header.php";
checkActiveLog($active_log);
 ?>



    <section id="account" class="account section">

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

    

        <div class="row">
            <div class="col-lg-12">
                 <div class="profile-menu">
                 <div class="row">
          <!-- Profile Menu -->
          <div class="col-lg-2">
           
      <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?php echo $imagePath.$profile_photo; ?>" alt="Profile" loading="lazy">
                </div>
                <h3> <?php echo htmlspecialchars($display_name); ?></h3>
           </div>
           </div>
		   
		   <div class="col-lg-10">
		   <div class="profile-links" data-aos="fade-left">
		     <?php include "links.php"; ?>
            </div>
</div>
<div class="col-md-2">
    <a href="my_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="my_orders.php" style="text-decoration: none; color:#fff;">My Purchases</a></h5>
            <p class="card-text text-white"><?php echo $paid_orders_count; ?></p>
        </div>
    </div>
</a>
</div>
<div class="col-md-2">
    <a href="manual_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="manual_orders.php" style="text-decoration: none; color:#fff;">Manual Purchases</a></h5>
            <p class="card-text text-white"><?php echo $pending_payments_count ; ?></p>
        </div>
    </div>
</a>
</div>
		   </div>
              </div>		
			   </div>
           </div>
           </div>

</section>

    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto">


   <!-- Checkout Forms Container -->
            <div class="checkout-forms" data-aos="fade-up" data-aos-delay="150">
              <!-- Step 1: Customer Information -->
              <div class="checkout-form active" data-form="1">
                <div class="form-header">
                  <h3>PERSONAL DETAILS</h3>
                 
                </div>
            <form class="checkout-form-element" method="post" enctype="multipart/form-data">
              <input type="hidden" name="action" value="">
  <!-- PERSONAL DETAILS -->
  <div class="row">
    <div class="col-md-3 form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Mr, Mrs, Miss, Ms, etc." value="<?php echo $title; ?>" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="first-name">First Name</label>
      <input type="text" name="first-name" class="form-control" id="first-name" placeholder="Your First Name"  value="<?php echo $first_name; ?>" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="middle-name">Middle Name</label>
      <input type="text" name="middle-name" class="form-control" id="middle-name" placeholder="Your Middle Name"  value="<?php echo $middle_name; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="last-name">Last Name</label>
      <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Your Last Name" required  value="<?php echo $last_name; ?>">
    </div>
  </div>

  <div class="form-group mt-3">
    <label for="profile">Tell Us About Yourself</label>
    <textarea class="form-control editor" name="profile" id="profile" placeholder="Your Profile" required><?php echo $biography; ?></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo">
    </div>

      <input type="hidden" name="age" class="form-control" id="age" placeholder="Must be 18 years and above"  >

    <div class="col-md-6 form-group">
      <label for="gender">Gender</label>
      <select class="form-control" id="gender" name="gender" required>
                                    <option value="">-Select Gender-</option>
                                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select> 
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="email">Email Address</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required value="<?php echo $email_address;?>">
    </div>
    <div class="col-md-6 form-group">
      <label for="phone">Phone Number</label>
      <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone Number" value="<?php echo $phone_number; ?>" required>
    </div>
  </div>
<div class="row mt-3">
					  <div class="col-md-6 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					<div class="input-group-append">
					<span class="input-group-text p-3" onclick="togglePasswordVisibility('password')">
						<i class="bi bi-eye" id="togglePasswordIcon"></i>
														</span>
													</div>
												</div>
					</div>
                   <div class="col-md-6 form-group">
                  <label>Password:</label>
                                  <div class="input-group">
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password" >
                                        <div class="input-group-append">
                                            <span class="input-group-text p-3" onclick="togglePasswordVisibility('retypePassword')">
                                                <i class="bi bi-eye" id="toggleRetypePasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                </div>
  <div class="form-group mt-3">
    <label for="skills">Skills and Hobbies</label>
    <textarea class="form-control editor" name="skills" id="skills" placeholder="List your skills and hobbies"><?php echo $skills_hobbies; ?></textarea>
  </div>

  <!-- LANGUAGE SECTION -->
      <input type="hidden" name="language" class="form-control" id="language" placeholder="Language" value="<?php echo $language; ?>" hidden>

      <select name="proficiency" class="form-control" id="proficiency" hidden>
          <option value="">Select Option</option>
        <option value="Unspecified" <?php echo ($proficiency == 'Unspecified') ? 'selected' : ''; ?>>Unspecified</option>
        <option value="Basic" <?php echo ($proficiency == 'Basic') ? 'selected' : ''; ?>>Basic</option>
        <option value="Conversational" <?php echo ($proficiency == 'Conversational') ? 'selected' : ''; ?>>Conversational</option>
        <option value="Fluent" <?php echo ($proficiency == 'Fluent') ? 'selected' : ''; ?>>Fluent</option>
        <option value="Native/Bilingual" <?php echo ($proficiency == 'Native/Bilingual') ? 'selected' : ''; ?>>Native/Bilingual</option>
      </select>
  

  <!-- COMPANY DETAILS -->
  <hr class="mt-5 mb-4">
  <h5>Company Details</h5>

<div class="form-group mt-3">
  <label for="company-name">Company Name</label>
  <input type="text" name="company-name" class="form-control" id="company-name" placeholder="Company Name" value="<?php echo $company_name; ?>">
</div>

<div class="form-group mt-3">
  <label for="company-profile">Company Profile</label>
  <textarea name="company-profile" class="form-control editor" id="company-profile" placeholder="Tell us about the company"><?php echo $company_profile; ?></textarea>
</div>

<div class="form-group mt-3">
  <label for="company-logo">Company Logo</label>
  <input type="file" name="company_profile_picture" class="form-control" id="company-logo">
</div>

    <textarea name="nigeria-office" hidden class="form-control"  placeholder="Full address in Nigeria"><?php echo $n_office_address; ?></textarea>


<div class="form-group mt-3">
  <label>Are you a Nigerian company?</label><br>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="is_nigerian" id="nigeriaYes" value="yes" 
      <?php echo ($country == 'Nigeria') ? 'checked' : ''; ?>>
    <label class="form-check-label" for="nigeriaYes">Yes</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="is_nigerian" id="nigeriaNo" value="no"
      <?php echo ($country != 'Nigeria') ? 'checked' : ''; ?>>
    <label class="form-check-label" for="nigeriaNo">No</label>
  </div>
</div>

<div id="nigeria-address-fields" style="display:none;">
  <div class="form-group mt-3">
    <label for="nigeria-office">Nigerian Office Address</label>
    <textarea name="nigeria-office" class="form-control editor" id="nigeria-office" placeholder="Full address in Nigeria"><?php echo $address; ?></textarea>
  </div>
  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="state">State</label>
      <input type="text" name="state" class="form-control" id="state" placeholder="State" value="<?php echo htmlspecialchars($state); ?>">
    </div>
    <div class="col-md-4 form-group">
      <label for="lga">LGA</label>
      <input type="text" name="lga" class="form-control" id="lga" placeholder="Local Government Area" value="<?php echo htmlspecialchars($lga); ?>">
    </div>
    <div class="col-md-4 form-group">
      <label for="country">Country</label>
      <input type="text" name="country" class="form-control" id="country_ng" value="Nigeria" readonly>
    </div>
  </div>
</div>

<div id="foreign-address-fields" style="display:none;">
  <div class="form-group mt-3">
    <label for="foreign-office">Foreign Office Address</label>
    <textarea name="foreign-office" class="form-control editor" id="foreign-office" placeholder="Full address of foreign office (if any)"><?php echo $address; ?></textarea>
  </div>
  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="country_foreign">Country</label>
      <select class="form-control" id="country_foreign" name="country_foreign">
        <option value="">-Select Country-</option>
        <?php
        $countryRes = mysqli_query($con, "SELECT name,nicename FROM ln_country ORDER BY name ASC");
        while ($countryRow = mysqli_fetch_assoc($countryRes)) {
          $selected = ($country == $countryRow['nicename'] || $country == $countryRow['name']) ? 'selected' : '';
          echo '<option value="'.htmlspecialchars($countryRow['nicename']).'" '.$selected.'>'.htmlspecialchars($countryRow['name']).'</option>';
        }
        ?>
      </select>
    </div>
  </div>
</div>

<textarea name="foreign-office" class="form-control" placeholder="Full address of foreign office (if any)" hidden><?php echo $f_office_address; ?></textarea>
<?php
$selected_categories = explode(',', $category);
$selected_subcategories = explode(',', $subcategory);

?>
<div class="mb-3">
  <label>Areas of Specialization & Expertise</label>
  <div class="custom-select-wrapper" id="category-wrapper">
    <div class="custom-select-display" onclick="toggleDropdown('category')">
      <div class="custom-select-tags" id="category-tags">
        <?php
          foreach ($selected_categories as $cat_id) {
            $cat_id = trim($cat_id);
            $cat_query = mysqli_query($con, "SELECT category_name FROM " . $siteprefix . "categories WHERE id = '$cat_id'");
            if ($row = mysqli_fetch_assoc($cat_query)) {
              echo '<span class="custom-tag" id="category-tag-' . $cat_id . '">' . htmlspecialchars($row['category_name']) . '</span>';
            }
          }
        ?>
      </div>
    </div>
    <div class="custom-select-dropdown" id="category-dropdown">
      <input type="search" class="form-control" placeholder="Search categories..." onkeyup="filterOptions(this, 'category-options')">
      <div id="category-options">
        <?php
          $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
          $res = mysqli_query($con, $sql);
          while ($row = mysqli_fetch_assoc($res)) {
            $checked = in_array($row['id'], $selected_categories) ? 'checked' : '';
            echo '<div class="custom-option">
                    <label>
                      <input type="checkbox" name="category[]" value="' . $row['id'] . '" onchange="updateTags(this, \'category\')" ' . $checked . '>
                      ' . htmlspecialchars($row['category_name']) . '
                    </label>
                  </div>';
          }
        ?>
      </div>
    </div>
  </div>

  <label>Subcategory</label>
  <div class="custom-select-wrapper" id="subcategory-wrapper" style="margin-top: 20px; display: none;">
    <div class="custom-select-display" onclick="toggleDropdown('subcategory')">
      <div class="custom-select-tags" id="subcategory-tags">
        <?php
          foreach ($selected_subcategories as $sub_id) {
            $sub_id = trim($sub_id);
            $sub_query = mysqli_query($con, "SELECT category_name FROM " . $siteprefix . "categories WHERE id = '$sub_id'");
            if ($row = mysqli_fetch_assoc($sub_query)) {
              echo '<span class="custom-tag" id="subcategory-tag-' . $sub_id . '">' . htmlspecialchars($row['category_name']) . '</span>';
            }
          }
        ?>
      </div>
    </div>
    <div class="custom-select-dropdown" id="subcategory-dropdown">
      <input class="form-control" type="search" placeholder="Search subcategories..." onkeyup="filterOptions(this, 'subcategory-options')">
      <div id="subcategory-options">
        <!-- JS will inject matching subcategories -->
      </div>
    </div>
  </div>
</div>

		</div> <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <div class="row mt-3">
       <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php echo htmlspecialchars($bank_name); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_accname" placeholder="Bank Account Name" value="<?php echo htmlspecialchars($bank_accname); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_number" placeholder="Bank Account Number" value="<?php echo htmlspecialchars($bank_number); ?>">
                            </div>
                            </div>
  <!-- Social Media -->
  <div class="row mt-3">
    <div class="col-md-3 form-group">
      <label for="facebook">Facebook</label>
      <input type="url" name="facebook" class="form-control" id="facebook" placeholder="Facebook profile" value="<?php echo $facebook; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="twitter">Twitter</label>
      <input type="url" name="twitter" class="form-control" id="twitter" placeholder="Twitter profile" value="<?php echo $twitter; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="instagram">Instagram</label>
      <input type="url" name="instagram" class="form-control" id="instagram" placeholder="Instagram profile" value="<?php echo $instagram; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="linkedin">LinkedIn</label>
      <input type="url" name="linkedin" class="form-control" id="linkedin" placeholder="LinkedIn profile" value="<?php echo $linkedin; ?>">
    </div>
  </div>
  <?php 
 if($trainer == 0 || $trainer == ''){ ?>
   <div class="mb-4 form-group d-flex align-items-center">
                <input type="checkbox" value="1" id="register_as_trainer" name="register_as_trainer" <?php echo isset($_POST['register_as_trainer']) ? 'checked' : ''; ?> class="me-2">
                <label for="register_as_trainer" class="mb-0">Become a trainer</label>
            </div>
            <?php }  ?>

  <div class="text-end mt-4">
    <button type="submit" name="update-profile" class="btn btn-primary">Submit</button>
  </div>
</form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </section>


    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("register_as_trainer");
    const nameInput = document.getElementById("company-name");
    const profileInput = document.getElementById("company-profile");
    const logoInput = document.getElementById("company-logo");

    function toggleRequiredFields() {
      const isChecked = checkbox.checked;
      nameInput.required = isChecked;
      profileInput.required = isChecked;
      logoInput.required = isChecked;
    }

    // Initial check on page load
    toggleRequiredFields();

    // Listen for change
    checkbox.addEventListener("change", toggleRequiredFields);
  });
</script>

 

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Trigger fetch after DOM loads
  fetchSubcategories();
});

function toggleDropdown(type) {
  document.getElementById(`${type}-dropdown`).classList.toggle('show');
}

function filterOptions(input, containerId) {
  const filter = input.value.toLowerCase();
  const options = document.getElementById(containerId).getElementsByClassName('custom-option');
  for (let i = 0; i < options.length; i++) {
    const text = options[i].innerText.toLowerCase();
    options[i].style.display = text.includes(filter) ? '' : 'none';
  }
}

function updateTags(checkbox, type) {
  const tagContainer = document.getElementById(`${type}-tags`);
  const tagId = `${type}-tag-${checkbox.value}`;
  const existingTag = document.getElementById(tagId);

  if (checkbox.checked && !existingTag) {
    const tag = document.createElement('span');
    tag.id = tagId;
    tag.className = 'custom-tag';
    tag.textContent = checkbox.parentElement.innerText.trim();
    tagContainer.appendChild(tag);
  } else if (!checkbox.checked && existingTag) {
    existingTag.remove();
  }

  if (type === 'category') fetchSubcategories();
}

function fetchSubcategories() {
  const selectedCategories = Array.from(document.querySelectorAll('input[name="category[]"]:checked')).map(cb => cb.value);
  const subWrapper = document.getElementById('subcategory-wrapper');
  const subOptions = document.getElementById('subcategory-options');

  subOptions.innerHTML = '';

  if (selectedCategories.length === 0) {
    subWrapper.style.display = 'none';
    return;
  }

  fetch(`get_subcategories.php?parent_ids=${selectedCategories.join(',')}`)
    .then(res => res.json())
    .then(data => {
      if (data.length > 0) {
        subWrapper.style.display = 'block';
        const selectedSub = <?= json_encode($selected_subcategories) ?>;

        data.forEach(sub => {
          const isChecked = selectedSub.includes(sub.s);
          const div = document.createElement('div');
          div.className = 'custom-option';
          div.innerHTML = `
            <label>
              <input type="checkbox" name="subcategory[]" value="${sub.s}" onchange="updateTags(this, 'subcategory')" ${isChecked ? 'checked' : ''}>
              ${sub.title}
            </label>
          `;
          subOptions.appendChild(div);
        });
      } else {
        subWrapper.style.display = 'none';
      }
    });
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  function setRequired(selectorList, required) {
    selectorList.forEach(function(sel) {
      document.querySelectorAll(sel).forEach(function(el) {
        if (required) {
          el.setAttribute('required', 'required');
        } else {
          el.removeAttribute('required');
        }
      });
    });
  }

  function toggleAddressFields() {
    const isNigerian = document.querySelector('input[name="is_nigerian"]:checked');
    const ngFields = document.getElementById('nigeria-address-fields');
    const foreignFields = document.getElementById('foreign-address-fields');

    if (isNigerian && isNigerian.value === 'yes') {
      ngFields.style.display = '';
      foreignFields.style.display = 'none';
      setRequired([
        '#nigeria-office', '#state', '#lga'
      ], true);
      setRequired([
        '#foreign-office', '#country_foreign'
      ], false);
    } else if (isNigerian && isNigerian.value === 'no') {
      ngFields.style.display = 'none';
      foreignFields.style.display = '';
      setRequired([
        '#nigeria-office', '#state', '#lga'
      ], false);
      setRequired([
        '#foreign-office', '#country_foreign'
      ], true);
    } else {
      ngFields.style.display = 'none';
      foreignFields.style.display = 'none';
      setRequired([
        '#nigeria-office', '#state', '#lga', '#foreign-office', '#country_foreign'
      ], false);
    }
  }

  document.querySelectorAll('input[name="is_nigerian"]').forEach(function(radio) {
    radio.addEventListener('change', toggleAddressFields);
  });
  toggleAddressFields();
});
</script>


<?php include "footer.php"; ?>