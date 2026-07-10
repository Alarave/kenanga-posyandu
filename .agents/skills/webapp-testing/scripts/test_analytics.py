from playwright.sync_api import sync_playwright
import sys

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        
        # Capture console messages
        def handle_console(msg):
            print(f'CONSOLE [{msg.type}]: {msg.text}')
            
        page.on('console', handle_console)
        
        # Handle page errors (uncaught exceptions)
        def handle_page_error(err):
            print(f'PAGE ERROR: {err}')
            
        page.on('pageerror', handle_page_error)
        
        try:
            # Assume local server is running on 8000, wait we need to login first
            pass
        except Exception as e:
            print(e)
            
        browser.close()

if __name__ == '__main__':
    run()

