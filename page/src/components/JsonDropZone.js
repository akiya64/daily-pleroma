import apiFetch from '@wordpress/api-fetch';
import { DropZone } from '@wordpress/components';

export const JsonDropZone = () => {

	return (
		<div>
			Json をドロップ
			<DropZone 
			onFilesDrop={ (files)=>{
				const formData = new FormData()
				formData.append(
					'outbox-json',
					files[0],
					files[0].name
				)

				apiFetch( {
					'path': '/daily-pleroma/v1/import-json',
					
					'method': 'POST',
					'body': formData
				} ).then().catch()
				} }
			/>
		</div>
	)
}
