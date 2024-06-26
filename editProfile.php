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
        /* border: 2px solid red; */
        width: 50%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 2rem;
    }

    .left-side-box {
        /* border: 2px solid red; */
        margin: 1rem;
    }

    .left-side-box img {
        /* border: 2px solid red; */
        border-radius: 10px;
        height: 250px;
        width: 300px;
    }

    .left-side-box .button-box {
        display: flex;
        justify-content: center;
    }

    .right-side-box {
        /* border: 2px solid red; */
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
        width: 100%;
    }

    .input-box {
        /* border: 2px solid red; */
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
        /* border: 2px solid black; */
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
</style>

<body>
    <section id="profile" class="container">
        <div class="profile-card">
            <div class="left-side-box">
                <img src="./assets/avatar.png" alt="avatar">
                <div class="button-box">
                    <button>
                        <a href="editProfile.php">
                            upload Avatar
                        </a>
                    </button>
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
                        <button>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</body>

</html>