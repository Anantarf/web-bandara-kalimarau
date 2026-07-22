export default function weatherWidget() {
    return {
        temp: '...',
        desc: 'Memuat cuaca...',
        icon: 'cloud',
        async fetchWeather() {
            try {
                const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=2.152&longitude=117.491&current_weather=true');
                const data = await res.json();
                const current = data.current_weather;
                this.temp = Math.round(current.temperature) + '°C';

                const code = current.weathercode;
                if (code <= 1) { this.desc = 'Cerah'; this.icon = 'sun'; }
                else if (code <= 3) { this.desc = 'Berawan'; this.icon = 'cloud'; }
                else if (code <= 48) { this.desc = 'Kabut'; this.icon = 'cloud'; }
                else if (code <= 57) { this.desc = 'Gerimis'; this.icon = 'rain'; }
                else if (code <= 82) { this.desc = 'Hujan'; this.icon = 'rain'; }
                else { this.desc = 'Badai Petir'; this.icon = 'lightning'; }
            } catch (e) {
                this.temp = '28°C';
                this.desc = 'Cerah';
                this.icon = 'sun';
            }
        },
    };
}
