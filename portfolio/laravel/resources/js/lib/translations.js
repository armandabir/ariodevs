import fa from '../../lang/fa.json';
import en from '../../lang/en.json';

const dictionaries = { fa, en };

export function translate(locale, key) {
    return dictionaries[locale]?.[key] ?? fa[key] ?? key;
}
