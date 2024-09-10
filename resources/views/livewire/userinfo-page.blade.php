<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Form</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <style>
    /* Ensure the image preview fits nicely */
    .profile-preview {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body class="bg-gray-50">

  <div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
    <form class="space-y-12">
      <!-- Profile Section -->
      <div class="pb-12 border-b border-gray-300">
        <h2 class="text-2xl font-semibold text-gray-900">Profile</h2>
        <p class="mt-1 text-gray-600">This information will be displayed publicly, so be careful what you share.</p>

        <div class="grid grid-cols-1 mt-10 gap-y-8 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-8">
          <!-- Username -->
          <div>
            <label for="username" class="block text-sm font-medium text-gray-900">Username</label>
            <div class="mt-2">
              <div class="flex items-center border border-gray-300 rounded-md shadow-sm focus-within:ring-2 focus-within:ring-indigo-600">
                <span class="flex items-center pl-3 text-gray-500">workcation.com/</span>
                <input type="text" id="username" name="username" autocomplete="username" placeholder="janesmith" class="flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
              </div>
            </div>
          </div>

          <!-- About -->
          <div class="col-span-full">
            <label for="about" class="block text-sm font-medium text-gray-900">About</label>
            <div class="mt-2">
              <textarea id="about" name="about" rows="3" placeholder="Write a few sentences about yourself." class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
            </div>
          </div>

          <!-- Photo -->
          <div class="col-span-full">
            <label for="photo" class="block text-sm font-medium text-gray-900">Profile Photo</label>
            <div class="flex items-center mt-2 gap-x-3">
              <div class="relative">
                <img id="photo-preview" src="https://via.placeholder.com/80" alt="Profile Preview" class="profile-preview">
                <input type="file" id="photo" name="photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewPhoto(event)">
              </div>
              <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Change</button>
            </div>
          </div>

          <!-- Cover Photo -->
          <div class="col-span-full">
            <label for="cover-photo" class="block text-sm font-medium text-gray-900">Cover photo</label>
            <div class="flex justify-center px-6 py-10 mt-2 border border-gray-300 border-dashed rounded-lg">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                </svg>
                <div class="flex items-center justify-center mt-4 text-sm text-gray-600">
                  <label for="file-upload" class="font-semibold text-indigo-600 bg-white border border-gray-300 rounded-md cursor-pointer hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <span>Upload a file</span>
                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                  </label>
                  <p class="ml-2">or drag and drop</p>
                </div>
                <p class="mt-1 text-xs text-gray-600">PNG, JPG, GIF up to 10MB</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Personal Information Section -->
      <div class="pb-12 border-b border-gray-300">
        <h2 class="text-2xl font-semibold text-gray-900">Personal Information</h2>
        <p class="mt-1 text-gray-600">Use a permanent address where you can receive mail.</p>

        <div class="grid grid-cols-1 mt-10 gap-y-8 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-8">
          <!-- First Name -->
          <div>
            <label for="first-name" class="block text-sm font-medium text-gray-900">First name</label>
            <div class="mt-2">
              <input type="text" id="first-name" name="first-name" autocomplete="given-name" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- Last Name -->
          <div>
            <label for="last-name" class="block text-sm font-medium text-gray-900">Last name</label>
            <div class="mt-2">
              <input type="text" id="last-name" name="last-name" autocomplete="family-name" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- Email Address -->
          <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
            <div class="mt-2">
              <input type="email" id="email" name="email" autocomplete="email" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- Country -->
          <div>
            <label for="country" class="block text-sm font-medium text-gray-900">Country</label>
            <div class="mt-2">
              <select id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                <option>United States</option>
                <option>Canada</option>
                <option>Mexico</option>
              </select>
            </div>
          </div>

          <!-- Street Address -->
          <div class="col-span-full">
            <label for="street-address" class="block text-sm font-medium text-gray-900">Street address</label>
            <div class="mt-2">
              <input type="text" id="street-address" name="street-address" autocomplete="street-address" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- City -->
          <div class="sm:col-span-3">
            <label for="city" class="block text-sm font-medium text-gray-900">City</label>
            <div class="mt-2">
              <input type="text" id="city" name="city" autocomplete="address-level2" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- State / Province -->
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-900">State / Province</label>
            <div class="mt-2">
              <input type="text" id="region" name="region" autocomplete="address-level1" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <!-- ZIP / Postal Code -->
          <div class="sm:col-span-2">
            <label for="postal-code" class="block text-sm font-medium text-gray-900">ZIP / Postal code</label>
            <div class="mt-2">
              <input type="text" id="postal-code" name="postal-code" autocomplete="postal-code" class="block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>
        </div>
      </div>

      <!-- Notifications Section -->
      <div class="pb-12 border-b border-gray-300">
        <h2 class="text-2xl font-semibold text-gray-900">Notifications</h2>
        <p class="mt-1 text-gray-600">We'll always let you know about important changes, but you pick what else you want to hear about.</p>

        <div class="mt-10 space-y-10">
          <!-- Email Notifications -->
          <fieldset>
            <legend class="text-sm font-semibold text-gray-900">By Email</legend>
            <div class="mt-6 space-y-6">
              <div class="relative flex gap-x-3">
                <div class="flex items-center h-6">
                  <input id="comments" name="comments" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600">
                </div>
                <div class="text-sm text-gray-900">
                  <label for="comments" class="font-medium">Comments</label>
                  <p class="text-gray-500">Get notified when someone posts a comment on a posting.</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex items-center h-6">
                  <input id="candidates" name="candidates" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600">
                </div>
                <div class="text-sm text-gray-900">
                  <label for="candidates" class="font-medium">Candidates</label>
                  <p class="text-gray-500">Get notified when a candidate applies for a job.</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex items-center h-6">
                  <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600">
                </div>
                <div class="text-sm text-gray-900">
                  <label for="offers" class="font-medium">Offers</label>
                  <p class="text-gray-500">Get notified when a candidate accepts or rejects an offer.</p>
                </div>
              </div>
            </div>
          </fieldset>

          <!-- Push Notifications -->
          <fieldset>
            <legend class="text-sm font-semibold text-gray-900">Push Notifications</legend>
            <p class="mt-1 text-gray-600">These are delivered via SMS to your mobile phone.</p>
            <div class="mt-6 space-y-6">
              <div class="flex items-center gap-x-3">
                <input id="push-everything" name="push-notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                <label for="push-everything" class="block text-sm font-medium text-gray-900">Everything</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input id="push-email" name="push-notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                <label for="push-email" class="block text-sm font-medium text-gray-900">Same as email</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input id="push-nothing" name="push-notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                <label for="push-nothing" class="block text-sm font-medium text-gray-900">No push notifications</label>
              </div>
            </div>
          </fieldset>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex justify-end mt-6 gap-x-6">
        <button type="button" class="text-sm font-semibold text-gray-900">Cancel</button>
        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-600">Save</button>
      </div>
    </form>
  </div>

  <script>
    function previewPhoto(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function(e) {
        const img = document.getElementById('photo-preview');
        img.src = e.target.result;
      }

      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>

</body>
</html>
