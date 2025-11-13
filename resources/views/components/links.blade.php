<ul class="social_links_wrapper">
    <li>
        <a href="https://vk.com/pristansvinki" target="_blank">
            <div class="footer_icon_block footer_icon_vk"></div>
        </a>
    </li>
    <li>
        <a href="https://t.me/pristansvinki " target="_blank">
            <div class="footer_icon_block footer_icon_telegram"></div>
        </a>
    </li>
    <li>
        <a href="https://dzen.ru/pristansvinki" target="_blank">
            <div class="footer_icon_block footer_icon_dzen"></div>
        </a>
    </li>
</ul>

<style>
    .social_links_wrapper {
        display: flex;
        column-gap: 20px;
    }

    .footer_icon_block {
        width: 48px;
        height: 48px;
        background-color: #EAB0C8;

        @media (max-width: 768px) {
            width: 36px;
            height: 36px;
            background-size: contain;
        }
    }

    .footer_icon_block:hover {
        background-color: #DE90B0;
    }

    .footer_icon_block:active::after {
        content: "";
        width: 100%;
        height: 100%;
        display: flex;
        background-color: #DE90B0;
        opacity: 0.5;
    }

    .footer_icon_block.footer_icon_vk {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/vk.png");
        background-position: center;
    }

    .footer_icon_block.footer_icon_telegram {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/tg.png");
        background-position: center;
    }

    .footer_icon_block.footer_icon_dzen {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/block.svg");
        background-position: center;
    }
</style>
