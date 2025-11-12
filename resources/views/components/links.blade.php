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

    .footer_icon_block.footer_icon_vk {
        background-image: url("/images/logo/footer/vk/default.png");
    }

    .footer_icon_block.footer_icon_vk:hover {
        background-image: url("/images/logo/footer/vk/hover.png");
    }

    .footer_icon_block.footer_icon_vk:active {
        background-image: url("/images/logo/footer/vk/click.png");
    }

    .footer_icon_block.footer_icon_telegram {
        background-image: url("/images/logo/footer/telegram/default.png");
    }

    .footer_icon_block.footer_icon_telegram:hover {
        background-image: url("/images/logo/footer/telegram/hover.png");
    }

    .footer_icon_block.footer_icon_telegram:active {
        background-image: url("/images/logo/footer/telegram/click.png");
    }

    .footer_icon_block.footer_icon_dzen {
        background-image: url("/images/logo/footer/dzen/default.png");
    }

    .footer_icon_block.footer_icon_dzen:hover {
        background-image: url("/images/logo/footer/dzen/hover.png");
    }

    .footer_icon_block.footer_icon_dzen:active {
        background-image: url("/images/logo/footer/dzen/click.png");
    }
</style>
