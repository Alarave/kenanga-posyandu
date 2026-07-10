const fs = require('fs');
const content = fs.readFileSync('resources/views/livewire/admin/analytics.blade.php', 'utf8');
const scriptMatch = content.match(/<script>([\s\S]*?)<\/script>/);

if (scriptMatch) {
    const code = scriptMatch[1];
    
    // Mock browser environment
    global.window = {};
    global.document = {
        getElementById: () => ({ 
            classList: { add: ()=>{}, remove: ()=>{} },
            getContext: () => ({})
        })
    };
    global.Chart = class Chart {
        constructor() {}
    };
    global.Chart.defaults = { font: {}, color: '' };
    
    // Mock Livewire
    global.$wire = {
        get: (prop) => {
            if (prop === 'trendLabels') return ['Jan'];
            return [10];
        },
        on: () => {}
    };

    try {
        // Execute the script
        eval(code);
        console.log('Script executed successfully!');
    } catch (e) {
        console.error('Runtime Error:', e);
    }
}
