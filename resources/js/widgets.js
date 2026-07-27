function initializeVkWidget() {
    if (!window.VK?.Widgets?.CommunityMessages) {
        return false;
    }

    window.VK.Widgets.CommunityMessages("vk_community_messages", 229736671, {
        tooltipButtonText: 'Связаться с нами'
    });

    return true;
}

if (!initializeVkWidget()) {
    document.getElementById('vk-openapi')?.addEventListener('load', initializeVkWidget, { once: true });
}
