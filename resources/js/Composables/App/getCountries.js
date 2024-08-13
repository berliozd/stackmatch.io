const countries = [
    {label: 'AT', name: 'Austria', id: 1},
    {label: 'AF', name: 'Afghanistan', id: 2},
    {label: 'AU', name: 'Austria', id: 3},
    {label: 'BE', name: 'Belgium', id: 4},
    {label: 'BR', name: 'Brazil', id: 5},
    {label: 'CA', name: 'Canada', id: 6},
    {label: 'CH', name: 'Switzerland', id: 7},
    {label: 'CN', name: 'China', id: 8},
    {label: 'CZ', name: 'Czech Republic', id: 9},
    {label: 'DK', name: 'Denmark', id: 10},
    {label: 'ES', name: 'Spain', id: 11},
    {label: 'FI', name: 'Finland', id: 12},
    {label: 'GB', name: 'United Kingdom', id: 13},
    {label: 'GR', name: 'Greece', id: 14},
    {label: 'HK', name: 'Hong Kong', id: 15},
    {label: 'IN', name: 'India', id: 16},
    {label: 'JP', name: 'Japan', id: 17},
    {label: 'KR', name: 'Korea', id: 18},
    {label: 'MX', name: 'Mexico', id: 19},
    {label: 'MY', name: 'Malaysia', id: 20},
    {label: 'US', name: 'United States', id: 21},
    {label: 'FR', name: 'France', id: 22},
    {label: 'IT', name: 'Italy', id: 23},
    {label: 'UK', name: 'United Kingdom', id: 24},
    {label: 'DE', name: 'Germany', id: 25},
    {label: 'IN', name: 'India', id: 26},
    {label: 'NL', name: 'Netherlands', id: 27},
    {label: 'PH', name: 'Philippines', id: 28},
    {label: 'RU', name: 'Russia', id: 29},
    {label: 'TR', name: 'Turkey', id: 30},
    {label: 'TW', name: 'Taiwan', id: 31},
    {label: 'VN', name: 'Vietnam', id: 32},
    {label: 'ZA', name: 'South Africa', id: 33},
];

export default () => {
    countries.sort((a, b) => {
        if (a.label > b.label) {
            return 1
        }
        return (a.label < b.label) ? -1 : 0
    })
    return countries
}
