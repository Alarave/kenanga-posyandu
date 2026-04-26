const fs = require('fs');
const path = require('path');

const walk = d => {
    fs.readdirSync(d).forEach(f => {
        const p = path.join(d, f);
        if (fs.statSync(p).isDirectory()) {
            walk(p);
        } else if (p.endsWith('.blade.php')) {
            let c = fs.readFileSync(p, 'utf8');
            const newC = c.replace(/route\('(schedules|users|patients|medical-records|articles|gallery)\./g, "route('admin.$1.");
            if (c !== newC) {
                fs.writeFileSync(p, newC);
                console.log('Fixed ' + p);
            }
        }
    });
};

walk('c:/Users/HP/posyandu-admin-dashboard/resources/views');
