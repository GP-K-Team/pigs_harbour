<div class="mobile_nav_wrapper">
    <ul>
        <li>
            Главная
        </li>
        <li>
            Ищут дом
        </li>
        <li>
            Как взять
        </li>
        <li>
            Статьи
        </li>
        <li>
            О нас
        </li>
        <li>
            <a href="https://vk.com/pristansvinki" target="_blank" class="vk_link">
                <div>
                    Группа
                </div>
                <div>
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_116_313)">
                            <path class="main_vk_logo" d="M12.9494 27.0107H14.0753C20.1962 27.0107 23.2445 27.0107 25.1345 25.1207C27.0137 23.2307 27.0137 20.1716 27.0137 14.0723V12.9248C27.0137 6.84984 27.0137 3.79074 25.1345 1.90074C23.2445 0.0107422 20.1854 0.0107422 14.0753 0.0107422H12.9494C6.82847 0.0107422 3.78017 0.0107422 1.89017 1.90074C0.0136719 3.79074 0.0136719 6.85254 0.0136719 12.9491V14.0966C0.0136719 20.1716 0.0136719 23.2307 1.90367 25.1207C3.79367 27.0107 6.85277 27.0107 12.9494 27.0107Z" fill="#323232"/>
                            <path d="M14.3804 19.4616C8.22709 19.4616 4.71709 15.2442 4.57129 8.22424H7.65469C7.75729 13.3758 10.028 15.5601 11.8289 16.0083V8.22424H14.7314V12.6684C16.508 12.4767 18.3764 10.4517 19.0055 8.22424H21.908C21.4274 10.5597 19.9964 12.5901 17.9579 13.8267C20.234 14.958 21.9161 17.01 22.5803 19.4616H19.3862C18.7841 17.307 16.9481 15.7248 14.7287 15.444V19.4616H14.3804Z" fill="#C3E3E1"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_116_313">
                                <rect width="27" height="27" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </a>
        </li>
    </ul>
    <div class="close_nav_button">
        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="close_menu_svg" d="M25.8076 2.73047L15.2305 13.3076L25.8076 23.8848L23.8848 25.8076L13.3076 15.2305L2.73047 25.8076L0.807617 23.8848L11.3848 13.3076L0.807617 2.73047L2.73047 0.807617L13.3076 11.3848L23.8848 0.807617L25.8076 2.73047Z" fill="#323232"/>
        </svg>
    </div>
</div>

<style>
    .mobile_nav_wrapper {
        display: none;
        position: absolute;
        top: 0;
        width: 100%;
        background-color: var(--main_blue);
    }

    .mobile_nav_wrapper ul {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .mobile_nav_wrapper li {
        width: 100%;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        font-weight: bold;
        cursor: pointer;
    }

    .mobile_nav_wrapper .vk_link {
        justify-content: center;
    }

    .close_nav_button {
        position: absolute;
        top: 15px;
        right: 25px;
    }

    .close_nav_button {
        cursor: pointer;
    }

    .close_nav_button:hover .close_menu_svg,
    li .vk_link:hover .main_vk_logo {
        fill: var(--dark_blue_font);
    }

    .mobile_nav_wrapper li:hover,
    .vk_link:hover {
        color: var(--dark_blue_font);
    }
</style>
