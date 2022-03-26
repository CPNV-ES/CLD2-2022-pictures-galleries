document.querySelector('.s3upload').addEventListener('submit', async function(event) {
  var form = this;
  var file_input = form.querySelector('input[type=file]');
  if (!file_input) { return; }
  
  event.preventDefault();
  
  var attributes = JSON.parse(form.dataset.s3attributes);
  var inputs = JSON.parse(form.dataset.s3inputs);
  
  var data = new FormData();
  for (input in inputs) {
    data.append(input, inputs[input]);
  }
  data.append('file', file_input.files[0]);

  var response = await fetch(attributes['action'], {method: attributes['method'], body: data});
  if (response.ok) {
    file_input.remove();
    form.submit();
  } else {
    console.log("Fail "+response.status);
  }
});
