<ul class="social-links-wrapper">
    <li>
        <a href="https://vk.com/pristansvinki" target="_blank">
            <div class="footer-icon-block footer-icon-vk"></div>
        </a>
    </li>
    <li>
        <a href="https://t.me/pristansvinki " target="_blank">
            <div class="footer-icon-block footer-icon-telegram"></div>
        </a>
    </li>
    <li>
        <a href="https://dzen.ru/pristansvinki" target="_blank">
            <div class="footer-icon-block footer-icon-dzen"></div>
        </a>
    </li>
</ul>

<style>
    .social-links-wrapper {
        display: flex;
        column-gap: 20px;
    }

    .footer-icon-block {
        width: 48px;
        height: 48px;
        background-color: #EAB0C8;

        @media (max-width: 768px) {
            width: 36px;
            height: 36px;
        }
    }

    .footer-icon-block:hover {
        background-color: #DE90B0;
    }

    .footer-icon-block:active::after {
        content: "";
        width: 100%;
        height: 100%;
        display: flex;
        background-color: #DE90B0;
        opacity: 0.5;
    }

    .footer-icon-block.footer-icon-vk {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/vk.png");
        background-position: center;
    }

    .footer-icon-block.footer-icon-telegram {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/tg.png");
        background-position: center;
    }

    .footer-icon-block.footer-icon-dzen {
        background-repeat: no-repeat;
        background-image: url("/images/logo/footer/dz.svg");
        background-position: center;
    }
</style>
