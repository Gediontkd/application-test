'use client';

import { List, Card } from "antd";
import { SpeechInterface } from "../../../../../types/DataModelTypes/SpeechInterface";
import SpeechItem from "./ProgramComponents/SpeechItem";

interface ProgramProps {
    program: SpeechInterface[];
}

export default function Program({ program }: ProgramProps) {
    return (
        <Card title="Program">
            <List
                dataSource={program}
                renderItem={speech => <SpeechItem speech={speech} />}
            />
        </Card>
    );
}
