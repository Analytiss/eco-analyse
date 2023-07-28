import { formatFloat } from './format';

export function exportBootstrapTableToArray(datas) {
    const result = [];
    datas.forEach((d) => {
        result.push([
            parseFloat(d.rateDegree) ?? null,
            parseFloat(d.setPoint),
            parseFloat(d.holdTime),
            parseFloat(d.runTime),
        ]);
    });
    return result.join(';');
}

export function formatResult(value, precision) {
    if (parseFloat(value.toFixed(precision)) === 0) {
        return formatFloat(parseFloat(value));
    } else {
        return value.toFixed(precision);
    }
}

export function formatArray(names, values) {
    const results = [];
    let increment = 0;
    names.forEach((entity) => {
        if (entity.value && values[increment].value) {
            results.push({
                code: entity.value,
                value: values[increment].value,
            });
        }
        increment++;
    });
    return results;
}
