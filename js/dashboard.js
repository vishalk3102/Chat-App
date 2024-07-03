var chatInterval;
    let currentActiveUser = null;
    // VARIABLE FOR MAINTAINING VIEW STATUS FOR BACK BUTTON (MOBILE DEVICE)
    const VIEW_MODE_USER_LIST = 'user_list';
    const VIEW_MODE_CHAT = 'chat';
    let currentViewMode = VIEW_MODE_USER_LIST;


    var receiver_userid = '';


    // DROPDOWN LOGIC 
    document.addEventListener('DOMContentLoaded', () => {
        const profileIcon = document.querySelector('.profile span');
        const dropdownContent = document.querySelector('.dropdown-content');

        function toggleDropdown(event) {
            event.stopPropagation();
            dropdownContent.classList.toggle('show');
        }

        function closeDropdown(event) {
            if (!profileIcon.contains(event.target) && dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
            }
        }

        profileIcon.addEventListener('click', toggleDropdown);
        document.addEventListener('click', closeDropdown);



    });



    
    function handleEnter(e) {
        if (event.key == "Enter" && !event.shiftKey) {

            event.preventDefault();
            handleMessage();
        }
    }
    function make_chat_area(user_name, username, user_status, chatStarted, user_photo) {
        var status_style = `<span class='dot' id='red'></span>`;
        if (user_status == 'Active') {
            status_style = `<span class='dot' id='green12'></span>`;
        }
        var htmlcode = `
                    <div class="chat-navbar user-text-box">
                        <div class="profile">
                            <img src="`+ user_photo + `" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">`+ user_name + `</p>
                            <p class="status-box">`+ username + `</p>
                            <p class="status-box">`+ status_style + user_status + `</p>

                        </div>
                    </div>
                    <div class="chat-content">
                        <div class="chat-text-box" id="message_text_box">
                            
                        </div>
                    </div>

                    <div class="chat-message-box">
                        <form id="messageForm" onsubmit="event.preventDefault(); handleMessage();" onkeypress="handleEnter(this)">
                            <textarea  type="text" id="user_text_message" placeholder="Type a message..." maxLength="255"></textarea>
                            <button type="submit" ><span><i class="fa fa-send-o"></i></span></button>
                        </form>
                    </div>
                    
                </div>
        `;
        document.getElementById('chatpart').innerHTML = htmlcode;
        var backButton = document.getElementById('backButton');
        var screenWidth = window.innerWidth;
        if (chatStarted && screenWidth <= 768) {
            backButton.style.display = 'block';
        } else {
            backButton.style.display = 'none';
        }
    }

    function loadChat(element) {

        document.querySelectorAll('.user-text-box').forEach(userBox => {
            userBox.classList.remove('active_user');
        });
        element.classList.add('active_user');
        receiver_userid = element.getAttribute('data-user-id');
        var receiver_name = document.getElementById('list_user_name_' + receiver_userid).innerHTML;
        var receiver_username = document.getElementById('list_user_username_' + receiver_userid).innerHTML;
        var receiver_status = document.getElementById('list_user_status_' + receiver_userid).innerHTML;
        var user_photo = document.getElementById('selected_user_image_' + receiver_userid).src;
        make_chat_area(receiver_name, receiver_username, receiver_status, true, user_photo);


        if (window.innerWidth <= 768) {
            document.querySelector('.users-box').classList.add('hidden');
            document.querySelector('.chat-box').classList.add('active');
        }
        if (chatInterval) {
            clearInterval(chatInterval);
        }

        fetchChat(receiver_userid);
        chatInterval = setInterval(() => fetchChat(receiver_userid), 3000);

    }
    // FUNCTION TO AUTO SCROLL MESSAGE TO BOTTOM
    function scrollToBottom() {
        var chatBox = document.querySelector('.chat-text-box');
        if (chatBox && !chatBox.hasScrolled) {
            const scrollHeight = chatBox.scrollHeight;
            const height = chatBox.clientHeight;
            const maxScrollTop = scrollHeight - height;

            // Smooth scroll to bottom
            chatBox.scrollTo({
                top: maxScrollTop,
                behavior: 'smooth'
            });

            // Mark as scrolled
            chatBox.hasScrolled = true;

            // Remove the scroll event listener after initial scroll
            chatBox.removeEventListener('scroll', preventAutoScroll);
        }
    }

    // Prevent auto-scrolling after user has manually scrolled
    function preventAutoScroll() {
        this.hasScrolled = true;
    }

    // Call this function when the chat is loaded
    function initializeChat() {
        var chatBox = document.querySelector('.chat-text-box');
        if (chatBox) {
            chatBox.hasScrolled = false;
            chatBox.addEventListener('scroll', preventAutoScroll);
            scrollToBottom();
        }
    }

    // Call initializeChat when your chat component is mounted or loaded
    initializeChat();

    function fetchChat(recUserId) {
        receiver_userid = recUserId
        var userId = document.getElementById('login_user_id').value;
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'to_user_id': receiver_userid,
                'from_user_id': userId,
                'action': 'fetch_chat',
            })
        })
            .then(response => response.text())
            .then(data => {
                // console.log("Response received: " + data);
                let response;
                try {
                    response = JSON.parse(data);
                } catch (e) {
                    console.log("Failed to parse JSON response: " + e);
                    return;
                }
                if (response.length > 0) {
                    var html_data = '';
                    for (var count = 0; count < response.length; count++) {
                        let read_check = `<span class="message_status_show"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 109.76" style="enable-background:new 0 0 122.88 109.76" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill:#01A601;}</style><g><path class="st0" d="M0,52.88l22.68-0.3c8.76,5.05,16.6,11.59,23.35,19.86C63.49,43.49,83.55,19.77,105.6,0h17.28 C92.05,34.25,66.89,70.92,46.77,109.76C36.01,86.69,20.96,67.27,0,52.88L0,52.88z"/></g></svg>
                                     </span>`;
                        if (response[count].message_status == 'send') {
                            read_check = `<span class="message_status_show"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 109.76" style="enable-background:new 0 0 122.88 109.76" xml:space="preserve">
                            <g>
                                <path style="fill:#000000;" d="M0,52.88l22.68-0.3c8.76,5.05,16.6,11.59,23.35,19.86C63.49,43.49,83.55,19.77,105.6,0h17.28 C92.05,34.25,66.89,70.92,46.77,109.76C36.01,86.69,20.96,67.27,0,52.88L0,52.88z"/>
                            </g>
                                </svg>

                            </span>`;
                        }
                        if (response[count].sender_id == userId) {
                            html_data += `<div class="sender-message">
                                <p> 
                                 <span class="show_message">`+ response[count].message + `</span>
                                    
                                     
                                     `+ read_check + `
                                </p>
                                <span>`+ response[count].timestamp + `</span>
                              
                            </div>`
                        }
                        else {
                            html_data += `
                            <div class="receiver-message">
                                <p>
                                    `+ response[count].message + `
                                </p>
                                <span>`+ response[count].timestamp + `</span>
                            </div>
                            `
                        }

                    }
                    document.getElementById('message_text_box').innerHTML = html_data;
                    setTimeout(scrollToBottom, 100);
                }

            })
            .catch(error => {
                window.alert("Fetch Error: " + error);
                console.error("Fetch Error: " + error);
            });
    }



    async function handleMessage() {

        var inputmsg = document.getElementById('user_text_message');
        var message = inputmsg.value.trim();
        let messagetodisplay = await escapeHtmlEntities(message);
        if (receiver_userid == '') {
            window.alert('something went wrong');
            return;
        }
        else if (message === '') {
            window.alert('message must not be empty');
            return;
        }
        var userId = document.getElementById('login_user_id').value;
        console.log(receiver_userid, userId);
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'to_user_id': receiver_userid,
                'from_user_id': userId,
                'message': message,
                'action': 'send_message',
            })
        })
            .then(response => response.text())
            .then(data => {
                let response;
                try {
                    response = JSON.parse(data);
                } catch (e) {
                    console.log("Failed to parse JSON response: " + e);
                    return;
                }
                if (response && parseInt(response.status) > 0) {
                    var html_data = '';
                    // let displayMessage=message.toString();
                    html_data += `<div class="sender-message">
                        <p>
                            ${messagetodisplay} 
                        </p>
                        <span>`+ response.timestamp + `</span>
                    </div>`

                    document.getElementById('message_text_box').innerHTML += html_data;
                    initializeChat();
                    setTimeout(scrollToBottom, 100);
                }

            })
            .catch(error => {
                console.error("Fetch Error: " + error);
            });
        inputmsg.value = '';
    }

    function escapeHtmlEntities(input) {
    // Replace special HTML characters with their entities
    return input.replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
    }



    // FUNCTION TO HIDE USER-BOX (MOBILE DEVICE)
    function showUsersList() {
        document.querySelector('.users-box').classList.remove('hidden');
        document.querySelector('.chat-box').classList.remove('active');
    }



    // FUNCTION TO HANDLE BACK BUTTON  CLICK(MOBILE DEVICE)
    function backToUserPage() {
        currentViewMode = VIEW_MODE_USER_LIST;
        toggleBackButtonVisibility();
        showUsersList();
    }

    // FUNCTION TO HANDLE HIDE/SHOW OF BACK BUTTON (MOBILE DEVICE)
    function toggleBackButtonVisibility() {
        var backButton = document.getElementById('backButton');
        if (currentViewMode === VIEW_MODE_CHAT) {
            backButton.style.display = 'block';
        } else {
            backButton.style.display = 'none';
        }
    }


    // Initial check on page load
    toggleBackButtonVisibility();

    // Listen for visibility changes
    document.addEventListener('visibilitychange', toggleBackButtonVisibility);

    function updateUsers() {
        var userId = document.getElementById('login_user_id').value;

        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId,
                'action': 'get_users',
            })
        })
            .then(response => response.json()) // Parse response as JSON
            .then(data => {
                console.log("Response received: ", data);
                if (Array.isArray(data)) {
                    // Construct HTML for users
                    let userHTML = '';
                    document.getElementById('users-box').innerHTML = '';
                    data.forEach(user => {
                        if (user.redirect) {
                            window.location.reload();
                        }
                        var status_style = `<span class='dot' id='red'></span>`;
                        var isActive = "";
                        if (user.status == 'Active') {
                            status_style = `<span class='dot' id='green12'></span>`;
                        }
                        if (receiver_userid != '' && user.user_id == receiver_userid) {
                            isActive = " active_user";
                        }
                        var unread = user.count_status != 0 ? `<span class='badge'>` + user.count_status + `</span>` : ``;
                        userHTML = `<div class='user-text-box chat_triggered_class ${isActive}' id='chat11_user_${user.user_id}'  data-user-id='${user.user_id}' onclick='loadChat(this)'>
                                    <div class='profile'>
                                        <img src='${user.imagepath}${user.photo}' id='selected_user_image_${user.user_id}' alt='avatar'>
                                    </div>
                                    <div class='text-box'>
                                        <p class='username-box notification' id='list_user_username_${user.user_id}'>` + user.username + unread + `</p>
                                          <p class='status-box ' id='list_user_name_${user.user_id}'>` + user.fname + ` ` + user.lname + `</p>
                                          <p class='status-box ' >`+ status_style + ` ` + `<span id='list_user_status_${user.user_id}'>` + user.status + `</span></p>
                                          
                                    </div>
                                </div>`;
                        document.getElementById('users-box').innerHTML += userHTML;
                    });
                    // Update the users-box element
                } else {
                    console.error('Invalid data format received.');
                    window.location.href = 'errorPage.php';
                }
            })
            .catch(error => {
                console.error("Fetch Error:", error);
            });
    }


    // userStatus();
    updateUsers()
    setInterval(updateUsers, 3000);