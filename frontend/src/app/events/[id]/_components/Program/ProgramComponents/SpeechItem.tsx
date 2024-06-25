// frontend/src/app/events/[id]/_components/Program/ProgramComponents/SpeechItem.tsx

import { List } from "antd";
import Utility from "../../../../../../../src/lib/Utility"
// import SpeechInterface
import { SpeechInterface } from "../../../../../../../src/types/DataModelTypes/SpeechInterface"

interface SpeechItemProps {
    speech: SpeechInterface;
}

export default function SpeechItem({ speech }: SpeechItemProps) {
    return (
        <List.Item key={`${speech.topic}-${speech.startTime}`}>
            <List.Item.Meta
                title={speech.topic || "No Topic"}
                description={
                    <>
                        <div>Speaker: {speech.speaker || "Unknown Speaker"}</div>
                        <div>
                            Time: {speech.startTime ? Utility.formatTime(speech.startTime) : "N/A"} - {speech.endTime ? Utility.formatTime(speech.endTime) : "N/A"}
                        </div>
                    </>
                }
            />
        </List.Item>
    );
}
