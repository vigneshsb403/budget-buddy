<body>
<div class="container">
  <h4 class="mb-3">Bill Splitter</h4>
  <form class="needs-validation" novalidate>
    <div class="row g-3">
      <div class="col-sm-6">
        <label for="billTitle" class="form-label">Bill Title</label>
        <input type="text" class="form-control" id="billTitle" placeholder="Enter bill title" required>
        <div class="invalid-feedback">
          Valid bill title is required.
        </div>
      </div>

      <div class="col-sm-6">
        <label for="billCost" class="form-label">Bill Cost</label>
        <input type="number" step="0.01" class="form-control" id="billCost" placeholder="Enter bill cost" required>
        <div class="invalid-feedback">
          Valid bill cost is required.
        </div>
      </div>

      <div class="col-12">
        <label for="numSplitters" class="form-label">Number of Splitters</label>
        <input type="number" class="form-control" id="numSplitters" placeholder="Enter number of splitters" required>
        <div class="invalid-feedback">
          Please enter the number of splitters.
        </div>
      </div>

      <div id="userInputs"></div> <!-- Container to dynamically add user input fields -->

      <div class="col-12">
        <label for="note" class="form-label">Note <span class="text-body-secondary">(Optional)</span></label>
        <textarea class="form-control" id="note" placeholder="Enter any additional notes"></textarea>
      </div>
    </div>
    <button class="btn btn-primary mt-3" type="submit">Submit</button>
  </form>
</div>
<script>
  document.getElementById('numSplitters').addEventListener('input', function() {
    const numSplitters = parseInt(this.value);
    const userInputsContainer = document.getElementById('userInputs');
    userInputsContainer.innerHTML = ''; // Clear previous inputs

    const firstUsername = '<?= Session::getUser()->getUsername() ?>'; // Auto-fill first username

    for (let i = 0; i < numSplitters; i++) {
      const userInputGroup = document.createElement('div');
      userInputGroup.className = 'col-12';
      userInputGroup.innerHTML = `
        <label for="username${i + 1}" class="form-label">Username ${i + 1}</label>
        <div class="input-group has-validation">
          <span class="input-group-text">@</span>
          <input type="text" class="form-control" id="username${i + 1}" value="${i === 0 ? firstUsername : ''}" placeholder="Username" required>
          <div class="invalid-feedback">
            Your username is required.
          </div>
        </div>
      `;
      userInputsContainer.appendChild(userInputGroup);
    }
  });

  const form = document.querySelector('.needs-validation');

  form.addEventListener('submit', async function(event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    event.preventDefault();

    const billTitle = document.getElementById('billTitle').value;
    const billCost = document.getElementById('billCost').value;
    const note = document.getElementById('note').value;
    const numSplitters = parseInt(document.getElementById('numSplitters').value);

    const usernames = [];

    for (let i = 0; i < numSplitters; i++) {
      usernames.push(document.getElementById(`username${i + 1}`).value);
    }

    const response = await fetch('proces_bill', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        billTitle,
        billCost,
        note,
        usernames
      })
    });

    if (response.ok) {
      alert('Bill added successfully!');
      form.reset();
      form.classList.remove('was-validated');
    } else {
      alert('Failed to add bill. Please try again.');
    }
  });
</script>
</body>
