<nav class="nav_bar">
    <div>
        <ul class="nav_list">
            <li>
                Ищут дом
            </li>
            <span>
                <img src="/images/icons/dot.svg" alt="Круглый элемент">
            </span>
            <li>
                Как взять
            </li>
        </ul>
    </div>
    <div class="logo_wrapper">
        <div class="logo_square"></div>
        <img class="logo_image" src="/images/logo.svg" alt="Логотип пристани" width="67" height="61">
    </div>
    <div>
        <ul class="nav_list">
            <li>
                Статьи
            </li>
            <span>
                <img src="/images/icons/dot.svg" alt="Круглый элемент">
            </span>
            <li>
                О нас
            </li>
            <li>
                <div class="special_link">
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
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="menu_burger">
    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path class="burger_menu_line" d="M25 2.75H0V5.25H25V2.75Z" fill="#323232"/>
        <path class="burger_menu_line" d="M25 11.25H0V13.75H25V11.25Z" fill="#323232"/>
        <path class="burger_menu_line" d="M25 19.75H0V22.25H25V19.75Z" fill="#323232"/>
    </svg>
</div>

@include('components.mobile_nav')

<style>
    .nav_bar {
        display: flex;
        align-items: center;
    }

    .nav_list {
        display: flex;
        align-items: center;
        column-gap: 15px;

        justify-content: end;
        min-width: 370px;
    }

    .nav_list li {
        padding: 5px 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .nav_list li:hover {
        color: var(--dark_blue_font);
    }

    .menu_burger {
        display: none;
        cursor: pointer;
    }

    .logo_wrapper {
        position: relative;
        padding: 0 20px;
        width: 200px;
    }

    .logo_image {
        position: absolute;
        bottom: -50px;
        left: 85px;
    }

    .logo_square {
        top: -150px;
        position: absolute;
        width: 200px;
        height: 200px;
        transform: rotate(45deg);
        background-color: #E2F4F4;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        border-radius: 30px;
    }

    .special_link {
        padding: 5px 10px;
        border: 2px solid var(--main_font);
        border-radius: 10px;
    }

    li .special_link:hover {
        border-color: var(--dark_blue_font);
    }

    li .special_link:hover .main_vk_logo,
    .menu_burger:hover .burger_menu_line {
        fill: var(--dark_blue_font);
    }

    .vk_link {
        display: flex;
        column-gap: 10px;
        align-items: center;
    }

    @media (max-width: 1200px) {
        .nav_list {
            column-gap: 5px;
        }
    }

    @media (max-width: 1000px) {
        .nav_list {
            column-gap: 5px;
            min-width: auto;
        }

        .nav_list li {
            padding: 5px 10px;
        }
    }

    @media (max-width: 850px) {
        .nav_list {
            display: none;
        }

        .menu_burger {
            display: block;
            position: absolute;
            right: 15px;
        }
    }
</style>
