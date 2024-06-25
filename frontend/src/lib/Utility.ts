
export default class Utility {
    static debounce(debouncedCallback: (...args: any[]) => any, delay: number = 500): (...args: any[]) => void {
        let timer: NodeJS.Timeout;

        return function (...args: any[]) {
            clearTimeout(timer);
            timer = setTimeout(() => debouncedCallback(...args), delay);
        };
    }

    static arrayOfObjsToHashMap<T>(array: T[], keyProp: string): { [key: string]: T } {
        const hashMap: { [key: string]: T } = {};

        array.forEach((item) => {
            hashMap[item[keyProp as keyof T] as string] = item;
        });

        return hashMap;
    }

    static formatTime(time: string | number): string {
        const date = new Date(time);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
}
