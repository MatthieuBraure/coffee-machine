import { startMachine, stopMachine } from '../api';

const statusLabels = {
    off: { label: "⛔ Éteinte", color: "gray" },
    starting: { label: "⚡ Démarrage...", color: "orange" },
    ready: { label: "✅ Prête", color: "green" },
    running: { label: "☕ En préparation", color: "blue" },
    shutdown: { label: "🛑 Arrêt en cours...", color: "red" },
};

export default function MachineStatus({ status, onRefresh }) {
    const label = statusLabels[status]?.label || 'Inconnu';
    const color = statusLabels[status]?.color || 'black';


    const disableStart = ['starting', 'ready', 'running', 'shutdown'].includes(status);
    const disableStop = ['off', 'shutdown'].includes(status);

    return (
        <div>
            <h2>☕ Machine à Café</h2>
            <p>Status : <strong style={{ color }}>{label}</strong></p>
            <button onClick={async () => { await startMachine(); onRefresh(); }} disabled={disableStart}>Démarrer</button>
            <button onClick={async () => { await stopMachine(); onRefresh(); }} disabled={disableStop}>Arrêter</button>
        </div>
    );
}
