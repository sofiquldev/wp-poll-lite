jQuery(document).ready(function ($) {
  const $pollQuestionInput = $("#pollQuestion");
  const $pollOptionsContainer = $("#pollOptions");
  const $addOptionButton = $("#addOptionButton");
  const $createPollButton = $("#createPollButton");
  const $createPollForm = $("#create-poll-form");

  // Add a new option
  $addOptionButton.on("click", function () {
    const optionCount = $pollOptionsContainer.find(".optionInput").length;
    $pollOptionsContainer.append(`
        <div class="poll-option">
          <input type="text" class="optionInput" placeholder="Option ${optionCount + 1}" />
          <button type="button" class="removeOptionButton">Remove</button>
        </div>
      `);
  });

  // Remove an option
  $pollOptionsContainer.on("click", ".removeOptionButton", function () {
    $(this).closest(".poll-option").remove();
  });

  // Create poll
  $createPollButton.on("click", function (event) {
    event.preventDefault();

    const question = $pollQuestionInput.val().trim();
    const options = $pollOptionsContainer
      .find(".optionInput")
      .map(function () {
        return $(this).val().trim();
      })
      .get()
      .filter((option) => option !== "");

    if (question === "" || options.length < 2) {
      alert("Please enter a question and at least two options.");
      return;
    }

    $createPollForm.submit();
    // If valid, display an alert or proceed with form submission
    // alert("Poll Created: " + question);
    // console.log("Poll Question:", question);
    // console.log("Poll Options:", options);
  });

});
