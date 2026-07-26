export default function weatherWidget() {
    return {
        temp: '...',
        desc: 'Memuat cuaca...',
        icon: 'cloud',
        isEstimate: false,
        async fetchWeather() {
            try {
                // Titik Bandara Kalimarau (BEJ): 2.1532°N 117.4260°E
                const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=2.1532&longitude=117.4260&current_weather=true');
                const data = await res.json();
                const current = data.current_weather;
                this.temp = Math.round(current.temperature) + '°C';

                const code = current.weathercode;
                const isNight = current.is_day === 0;
                if (code <= 1) { this.desc = 'Cerah'; this.icon = isNight ? 'moon' : 'sun'; }
                else if (code <= 3) { this.desc = 'Berawan'; this.icon = 'cloud'; }
                else if (code <= 48) { this.desc = 'Kabut'; this.icon = 'cloud'; }
                else if (code <= 57) { this.desc = 'Gerimis'; this.icon = 'rain'; }
                else if (code <= 67 || (code >= 80 && code <= 82)) { this.desc = 'Hujan'; this.icon = 'rain'; }
                else if (code <= 77 || (code >= 85 && code <= 86)) { this.desc = 'Berawan'; this.icon = 'cloud'; }
                else { this.desc = 'Badai Petir'; this.icon = 'lightning'; }
            } catch (e) {
                this.temp = '28°C';
                this.desc = 'Cerah (perkiraan)';
                this.icon = 'sun';
                this.isEstimate = true;
            }
        },
    };
}
