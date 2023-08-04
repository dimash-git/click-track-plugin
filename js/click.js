document.addEventListener("DOMContentLoaded", function () {
  const buttonClass = "click_track";
  const userClickButtons = document.getElementsByClassName(buttonClass);
  Array.from(userClickButtons).forEach(function (button) {
    button.addEventListener("click", async function () {
      const { adminUrl, userId } = clickObject;

      try {
        const response = await fetch(
          `${adminUrl}?action=update_user_click&user_id=${userId}`,
          {
            method: "GET",
          }
        );

        if (response.ok) {
          console.log("User click updated successfully");
        } else {
          console.log("Failed to update user click");
        }
      } catch (error) {
        console.log("An error occurred:", error);
      }
    });
  });
});
