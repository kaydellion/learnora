
<?php include "header.php"; ?>


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
              <input type="hidden" name="action" value="register">
  <!-- PERSONAL DETAILS -->
  <div class="row">
    <div class="col-md-3 form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Mr, Mrs, Miss, Ms, etc." required>
    </div>
    <div class="col-md-3 form-group">
      <label for="first-name">First Name</label>
      <input type="text" name="first-name" class="form-control" id="first-name" placeholder="Your First Name" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="middle-name">Middle Name</label>
      <input type="text" name="middle-name" class="form-control" id="middle-name" placeholder="Your Middle Name">
    </div>
    <div class="col-md-3 form-group">
      <label for="last-name">Last Name</label>
      <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Your Last Name" required>
    </div>
  </div>

  <div class="form-group mt-3">
    <label for="profile">Tell Us About Yourself</label>
    <textarea class="form-control editor" name="profile" id="profile" placeholder="Your Profile" required></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo" required>
    </div>
    <div class="col-md-4 form-group">
      <label for="age">Age</label>
      <input type="hidden" name="age" class="form-control" id="age" placeholder="Must be 18 years and above" hidden>
    </div>
    <div class="col-md-4 form-group">
      <label for="gender">Gender</label>
      <select class="form-control" id="gender" name="gender" required>
        <option value="">-Select Gender-</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
      </select>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="email">Email Address</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="phone">Phone Number</label>
      <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone Number" required>
    </div>
  </div>
<div class="row mt-3">
					  <div class="col-md-6 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
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
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-3" onclick="togglePasswordVisibility('retypePassword')">
                                                <i class="bi bi-eye" id="toggleRetypePasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                </div>
  <div class="form-group">
   
    <textarea class="form-control editor" name="skills" id="skills" placeholder="List your skills and hobbies" hidden></textarea>
  </div>


      <input type="text" name="language" class="form-control" id="language" placeholder="Language" hdden>
    </div>

      <select name="proficiency" class="form-control" id="proficiency" hidden>
          <option value="">Select Option</option>
        <option value="Unspecified">Unspecified</option>
        <option value="Basic">Basic</option>
        <option value="Conversational">Conversational</option>
        <option value="Fluent">Fluent</option>
        <option value="Native/Bilingual">Native/Bilingual</option>
      </select>
  

  <!-- COMPANY DETAILS -->
  <hr class="mt-5 mb-4">
  <h5>Company Details</h5>

  <div class="form-group mt-3">
    <label for="company-name">Company Name</label>
    <input type="text" name="company-name" class="form-control" id="company-name" placeholder="Company Name">
  </div>

  <div class="form-group mt-3">
    <label for="company-profile">Company Profile</label>
    <textarea name="company-profile" class="form-control editor" id="company-profile" placeholder="Tell us about the company"></textarea>
  </div>

  <div class="form-group mt-3">
    <label for="company-logo">Company Logo</label>
    <input type="file" name="company_profile_picture" class="form-control" id="company-logo">
  </div>

  <!-- Nigerian Office -->
  <div class="form-group">
    
    <textarea hidden name="nigeria-office" class="form-control editor"  placeholder="Full address in Nigeria"></textarea>
  </div>

  
  <!-- Foreign Office -->
  <div class="form-group mt-3">

    <textarea hidden name="foreign-office" class="form-control editor" placeholder="Full address of foreign office (if any)"></textarea>
  </div>
<div class="row mt-3">
  <div class="col-md-6 form-group">
    <label>Are you a Nigerian company?</label><br>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="is_nigerian" id="nigeriaYes" value="yes" required>
      <label class="form-check-label" for="nigeriaYes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="is_nigerian" id="nigeriaNo" value="no">
      <label class="form-check-label" for="nigeriaNo">No</label>
    </div>
  </div>
</div>
    
<div id="nigeria-address-fields" style="display:none;">

  <div class="row mt-3">
      <div class="col-md-12 form-group mt-3">
    <label for="full_address_ng">Full Address</label>
    <textarea class="form-control editor" name="full_address_ng" id="full_address_ng" placeholder="Full Address"></textarea>
  </div>
    <div class="col-md-4 form-group">
      <label for="state">State</label>
      <select id="state" name="state" class="form-control">
        <option value="">-Select State-</option>
      </select>
    </div>
    <div class="col-md-4 form-group">
      <label for="lga">LGA</label>
      <select class="form-control" id="lga" name="lga">
        <option value="">-Select LGA-</option>
      </select>
    </div>
    <div class="col-md-4 form-group">
      <label for="country_ng">Country</label>
      <input type="text" class="form-control" id="country_ng" name="country_ng" value="Nigeria" readonly>
    </div>
  </div>
</div>
 



<div id="foreign-address-fields" style="display:none;">
  <div class="form-group mt-3">
    <label for="full_address_foreign">Full Address</label>
    <input type="text" class="form-control" name="full_address_foreign" id="full_address_foreign" placeholder="Full Address">
  </div>
  <div class="row mt-3">
 <div class="col-md-6 form-group">
  <label for="country_foreign">Country</label>
  <select class="form-control" id="country_foreign" name="country_foreign">
    <option value="">-Select Country-</option>
    <?php
    $countryRes = mysqli_query($con, "SELECT name,nicename FROM ln_country ORDER BY name ASC");
    while ($countryRow = mysqli_fetch_assoc($countryRes)) {
      echo '<option value="'.htmlspecialchars($countryRow['nicename']).'">'.htmlspecialchars($countryRow['name']).'</option>';
    }
    ?>
  </select>
</div>
  </div>
</div>

  <div class="mb-3">
                          <label>Areas of Specialization & Expertise</label>
                      <div class="custom-select-wrapper" id="category-wrapper">
  <div class="custom-select-display" onclick="toggleDropdown('category')">
    <div class="custom-select-tags" id="category-tags"></div>
  </div>
  <div class="custom-select-dropdown" id="category-dropdown">
    <input type="search" class="form-control" placeholder="Search categories..." onkeyup="filterOptions(this, 'category-options')">
    <div id="category-options">
      <?php
        $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
        $res = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
          echo '<div class="custom-option">
                  <label>
                    <input type="checkbox" name="category[]" value="' . $row['id'] . '" onchange="updateTags(this, \'category\')">
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
    <div class="custom-select-tags" id="subcategory-tags"></div>
  </div>
  <div class="custom-select-dropdown" id="subcategory-dropdown">
    <input class="form-control" type="search" placeholder="Search subcategories..." onkeyup="filterOptions(this, 'subcategory-options')">
    <div id="subcategory-options">
      <!-- Subcategory checkboxes inserted dynamically -->
    </div>
  </div>
</div>
                        </div>
  <!-- Social Media -->
  <div class="row mt-3">
    <div class="col-md-3 form-group">
      <label for="facebook">Facebook</label>
      <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Facebook profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="twitter">Twitter</label>
      <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Twitter profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="instagram">Instagram</label>
      <input type="text" name="instagram" class="form-control" id="instagram" placeholder="Instagram profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="linkedin">LinkedIn</label>
      <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="LinkedIn profile URL">
    </div>
  </div>

  <div class="text-end mt-4">
    <button type="submit" name="register-user" class="btn btn-primary">Submit</button>
  </div>
</form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

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
        '#full_address_ng', '#state', '#lga'
      ], true);
      setRequired([
        '#full_address_foreign', '#country_foreign'
      ], false);
    } else if (isNigerian && isNigerian.value === 'no') {
      ngFields.style.display = 'none';
      foreignFields.style.display = '';
      setRequired([
        '#full_address_ng', '#state', '#lga'
      ], false);
      setRequired([
        '#full_address_foreign', '#country_foreign'
      ], true);
    } else {
      ngFields.style.display = 'none';
      foreignFields.style.display = 'none';
      setRequired([
        '#full_address_ng', '#state', '#lga', '#full_address_foreign', '#country_foreign'
      ], false);
    }
  }

  document.querySelectorAll('input[name="is_nigerian"]').forEach(function(radio) {
    radio.addEventListener('change', toggleAddressFields);
  });
  toggleAddressFields();
});
</script>

                      <script>
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
        data.forEach(sub => {
          const div = document.createElement('div');
          div.className = 'custom-option';
          div.innerHTML = `
            <label>
              <input type="checkbox" name="subcategory[]" value="${sub.s}" onchange="updateTags(this, 'subcategory')">
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

<?php include "footer.php"; ?>