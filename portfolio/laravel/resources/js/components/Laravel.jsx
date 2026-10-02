import React, { useEffect, useRef } from 'react';
import styles from '../css/styles/Laravel.module.scss';

export default function Laravel() {
    const terminalRef = useRef(null);

    useEffect(() => {
        const terminalBody = terminalRef.current;
        if (!terminalBody) return;

        let epoch = 1;
        const totalEpochs = 50;
        let loss = 2.453;
        let accuracy = 0.45;
        let timeoutId;
        let stopped = false;

        const logMessages = [
            () => `[INFO] Loading dataset 'banking-conversations-v2'...`,
            () => `[INFO] Initializing distributed training across 4 GPUs...`,
            () => `[WARN] <span class="warning">VRAM usage at 88%. Enabling gradient checkpointing.</span>`,
            () => `Epoch ${epoch}/${totalEpochs} - <span class="keyword">Loss:</span> <span class="value">${loss.toFixed(4)}</span> - <span class="keyword">Accuracy:</span> <span class="value">${accuracy.toFixed(2)}</span>`,
            () => `[INFO] Running validation step...`,
            () => `[SUCCESS] <span class="success">Checkpoint saved to ./weights/llama3-finetuned-step-800.pt</span>`,
            () => `[INFO] Adjusting learning rate to 2e-5 with Cosine Annealing...`,
            () => `[INFO] Garbage collection freed 1.2GB of memory.`,
        ];

        function updateMetrics() {
            epoch = epoch >= totalEpochs ? 1 : epoch + 1;
            loss = Math.max(0.1, loss - Math.random() * 0.15);
            accuracy = Math.min(0.99, accuracy + Math.random() * 0.05);
            if (epoch === 1) {
                loss = 2.5;
                accuracy = 0.4;
            }
        }

        let lineCount = 0;
        const maxLines = 8;

        function addLogLine() {
            if (stopped) return;
            if (lineCount >= maxLines) {
                terminalBody.removeChild(terminalBody.firstChild);
            } else {
                lineCount++;
            }

            let msgFunc = Math.random() > 0.4 ? logMessages[3] : logMessages[Math.floor(Math.random() * logMessages.length)];

            if (msgFunc === logMessages[3]) {
                updateMetrics();
            }

            const newLine = document.createElement('div');
            newLine.className = 'term-line';
            const time = new Date().toISOString().split('T')[1].substring(0, 8);
            newLine.innerHTML = `<span style="color:#8b949e">[${time}]</span> ${msgFunc()}`;

            const cursor = document.createElement('span');
            cursor.className = 'term-cursor';
            newLine.appendChild(cursor);

            const oldCursor = terminalBody.querySelector('.term-cursor');
            if (oldCursor) oldCursor.remove();

            terminalBody.appendChild(newLine);

            const nextTick = 800 + Math.random() * 1700;
            timeoutId = setTimeout(addLogLine, nextTick);
        }

        timeoutId = setTimeout(addLogLine, 1000);

        return () => {
            stopped = true;
            clearTimeout(timeoutId);
        };
    }, []);

    return (
        <div className={`bento-box bento-medium reveal ${styles.terminalBox}`}>
            <div className={styles.terminalHeader}>
                <div className={styles.termDots}>
                    <span className={`${styles.dot} ${styles.close}`}></span>
                    <span className={`${styles.dot} ${styles.min}`}></span>
                    <span className={`${styles.dot} ${styles.max}`}></span>
                </div>
                <div className={`${styles.termTitle} en-text`}>aria@gpu-server: ~/llm-finetune</div>
            </div>
            <div className={`${styles.terminalBody} en-text`} id="live-terminal" ref={terminalRef}></div>
        </div>
    );
}
