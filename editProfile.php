<!DOCTYPE html>
<html lang="en">
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #030617;
        height: 100vh;
        width: 100%;
    }

    .profile-card {
        width: 50%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 2rem;
    }

    .left-side-box {
        margin: 1rem;
    }

    .left-side-box img {
        border-radius: 10px;
        height: 250px;
        width: 300px;
    }

    .left-side-box .button-box {
        display: flex;
        justify-content: center;
    }

    .right-side-box {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
        width: 100%;
    }

    .input-box {
        margin-bottom: 5px;
    }

    .input-box span {
        font-size: 14px;
        font-weight: 600;
    }

    .input-box input {
        font-size: 1rem;
        display: flex;
        align-items: center;
        padding: 5px;
        width: 100%;
        outline: none;
        border: 1px solid black;
    }

    .button-box {
        margin-top: 1rem;
    }

    .button-box button {
        border: 2px solid black;
        border-radius: 5px;
        padding: 10px 16px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        background-color: #030617;
        color: #fff;
        margin: 10px 5px;
    }

    .button-box button a {
        color: #fff;
        text-decoration: none;
    }

    .button-box button:hover {
        cursor: pointer;
    }


    /* MODAL BOX STYLING  */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        background-color: #ebeef3;
        padding: 1rem;
        border-radius: 10px;
    }

    .modal h4 {
        font-size: 1.2rem;
        text-align: center;
        padding: 5px;
        margin: 1rem 0px;
    }

    .avatar-options {
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }

    .avatar-options .avatar-option {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        cursor: pointer;
        border: 1px solid black;
        margin: 10px;
        transition: border-color 0.3s ease;
    }
</style>

<body>
    <section id="profile" class="container">
        <div class="profile-card">
            <div class="left-side-box">
                <img src="./assets/avatar.png" alt="avatar">
                <div class="button-box">
                    <button>
                        <a href="editProfile.php">
                            Change Avatar
                        </a>
                    </button>
                </div>
                <div id="avatarModal" class="modal">
                    <div class="modal-content">
                        <h4>Select Your New Avatar</h4>
                        <div class="avatar-options">
                            <img src="./assets/avatar1.jpg" onclick="selectAvatar(this)" alt="Avatar 1"
                                class="avatar-option">
                            <img src="./assets/avatar2.jpg" onclick="selectAvatar(this)" alt="Avatar 2"
                                class="avatar-option">
                            <img src="./assets/avatar3.png" onclick="selectAvatar(this)" alt="Avatar 3"
                                class="avatar-option">
                            <img src="./assets/avatar4.jpg" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
                            <img src="./assets/avatar5.jpg" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
                            <img src="./assets/avatar6.png" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
                        </div>
                        <div class="modal-footer button-box">
                            <button id="closeBtn">Close</button>
                            <button id="saveBtn">Save</button>
                        </div>
                    </div>

                </div>

            </div>
            <div class="right-side-box">
                <form action="#">
                    <div class="input-box">
                        <span>First Name : </span>
                        <input type="text" placeholder="Enter your first name" required>
                    </div>
                    <div class="input-box">
                        <span>Middle Name : </span>
                        <input type="text" placeholder="Enter your middle name" required>
                    </div>
                    <div class="input-box">
                        <span>Last Name : </span>
                        <input type="text" placeholder="Enter your last name" required>
                    </div>
                    <div class="input-box">
                        <span>Email : </span>
                        <input type="text" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span>Username : </span>
                        <input type="text" placeholder="Enter your user name" required>
                    </div>
                    <div class="button-box">
                        <button id="change-avatar-btn">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
    // Function to open the modal
    function openModal() {
        const modal = document.getElementById('avatarModal');
        modal.style.display = 'block';
    }

    // Function to select an avatar
    function selectAvatar(imgElement) {
        updateAvatarImage(imgElement.src);
    }

    // Function to close the modal
    function closeModal() {
        const modal = document.getElementById('avatarModal');
        modal.style.display = 'none';
    }

    // Function to update the avatar image
    function updateAvatarImage(src) {
        const avatarImage = document.querySelector('.left-side-box img');
        avatarImage.src = src;
        console.log('Selected Avatar:', src);
    }

    // Attach event listeners
    document.querySelector('.button-box').addEventListener('click', openModal);
    document.getElementById('closeBtn').addEventListener('click', closeModal);
    document.getElementById('saveBtn').addEventListener('click', () => {
        // Save logic here
        closeModal();
    });

</script>

</html>